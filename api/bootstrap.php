<?php

// B04: Public bootstrap API allows GET requests only.
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Allow: GET');
    http_response_code(405);
    exit;
}

require __DIR__ . "/config.php";

date_default_timezone_set("America/Chicago");


function donationIsCurrent($donation)
{
    $pickupDate = trim($donation["pickup_date"] ?? "");

    if ($pickupDate === "") {
        return true;
    }

    $pickupEnd = trim($donation["pickup_end"] ?? "");

    if ($pickupEnd === "") {
        $pickupEnd = "23:59:59";
    }

    try {
        $timezone = new DateTimeZone("America/Chicago");

        $deadline = new DateTime(
            $pickupDate . " " . $pickupEnd,
            $timezone
        );

        $now = new DateTime("now", $timezone);

        return $deadline >= $now;

    } catch (Throwable $e) {
        return true;
    }
}


/*
|--------------------------------------------------------------------------
| Public donor / charity counts
|--------------------------------------------------------------------------
|
| B01 (revised): the public homepage only shows HOW MANY donors and
| charities exist. Names, IDs, and addresses are never sent publicly;
| they are visible only in the Admin panel.
|
| Counts match the Admin lists: every non-archived record is counted.
| To hide a record from the public count, Archive it in Admin.
|
*/

$restaurantCount = (int)$pdo->query(
    "SELECT COUNT(*)
     FROM restaurants
     WHERE status <> 'archived'"
)->fetchColumn();

$charityCount = (int)$pdo->query(
    "SELECT COUNT(*)
     FROM charities
     WHERE status <> 'archived'"
)->fetchColumn();


/*
|--------------------------------------------------------------------------
| Public food listings (count only)
|--------------------------------------------------------------------------
*/

/*
 * Same rule as the Admin dashboard's "available donations" figure,
 * so the public number and the Admin number always match.
 */
$stmt = $pdo->query(
    "SELECT
        pickup_date,
        pickup_end
     FROM food_donations
     WHERE status = 'available'
       AND COALESCE(
            available_quantity,
            quantity,
            0
       ) > 0"
);

$currentFoodCount = count(
    array_filter(
        $stmt->fetchAll(),
        "donationIsCurrent"
    )
);


/*
|--------------------------------------------------------------------------
| Impact panel totals (counts only — nothing identifiable)
|--------------------------------------------------------------------------
|
| Each figure is wrapped in try/catch: if a table or column does not
| exist yet, that figure is sent as null and the homepage shows "—"
| rather than a made-up number.
|
*/

/*
 * Completed rescues: same source of truth as the Admin dashboard.
 * Completion is owned by delivery_groups, not by the donation row
 * (a donation can stay "available" after part of it is rescued).
 */
$completedCount = null;
try {
    $completedCount = (int)$pdo->query(
        "SELECT COUNT(*)
         FROM delivery_groups
         WHERE status = 'completed'"
    )->fetchColumn();
} catch (Throwable $e) {
    $completedCount = null;
}

/*
 * Volunteers: same rule as the Admin dashboard (every non-archived
 * volunteer). Count only; no volunteer details are ever returned.
 */
$volunteerCount = null;
try {
    $volunteerCount = (int)$pdo->query(
        "SELECT COUNT(*)
         FROM volunteers
         WHERE status <> 'archived'"
    )->fetchColumn();
} catch (Throwable $e) {
    $volunteerCount = null;
}

/*
 * Bio waste avoided this month, in pounds (lbs) — the US unit donors use.
 *
 * Counts the rescued quantity of completed rescues (delivery_groups =
 * 'completed') whose donation was recorded in pounds ("lbs" is the only
 * weight unit donors can choose). Items, packs, boxes, etc. are NOT
 * converted, so the figure is never an estimate.
 *
 * delivery_groups has no completion date, so "this month" uses the
 * donation's pickup date. A food request can be marked 'approved' or
 * 'completed' after delivery depending on which page confirmed it, so
 * both are counted. If no weighed rescue exists yet, this stays null.
 */
$wasteLbsMonth = null;
try {
    $wasteRow = $pdo->query(
        "SELECT
            SUM(CASE
                WHEN LOWER(TRIM(d.unit)) IN ('lb','lbs','pound','pounds')
                    THEN fr.requested_quantity
                WHEN LOWER(TRIM(d.unit)) IN ('kg','kgs','kilogram','kilograms')
                    THEN fr.requested_quantity * 2.20462
                ELSE 0
            END) AS lbs_total,
            SUM(CASE
                WHEN LOWER(TRIM(d.unit)) IN (
                    'lb','lbs','pound','pounds',
                    'kg','kgs','kilogram','kilograms'
                ) THEN 1
                ELSE 0
            END) AS weighed_rows
         FROM food_requests fr
         JOIN delivery_groups dg
           ON dg.id = fr.delivery_group_id
         JOIN food_donations d
           ON d.id = fr.food_donation_id
         WHERE dg.status = 'completed'
           AND fr.status IN ('approved', 'completed')
           AND d.pickup_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
           AND d.pickup_date <  DATE_FORMAT(CURDATE() + INTERVAL 1 MONTH, '%Y-%m-01')"
    )->fetch();

    if ($wasteRow && (int)$wasteRow['weighed_rows'] > 0) {
        $wasteLbsMonth = round((float)$wasteRow['lbs_total'], 1);
    }
} catch (Throwable $e) {
    $wasteLbsMonth = null;
}

$impact = [
    "available_donations" => $currentFoodCount,
    "completed_donations" => $completedCount,
    "food_donors"         => $restaurantCount,
    "partner_charities"   => $charityCount,
    "volunteers"          => $volunteerCount,
    "waste_lbs_month"     => $wasteLbsMonth
];


/*
|--------------------------------------------------------------------------
| Keep the array shape the homepage already expects
|--------------------------------------------------------------------------
|
| The homepage counts array lengths, so each entry is an anonymous
| placeholder containing nothing identifiable.
|
*/

$restaurants  = array_fill(0, $restaurantCount,  ["status" => "active"]);
$charities    = array_fill(0, $charityCount,     ["status" => "active"]);
$foodListings = array_fill(0, $currentFoodCount, ["status" => "available"]);


/*
|--------------------------------------------------------------------------
| Public site settings
|--------------------------------------------------------------------------
*/

$settings = [
    "site_name" => "ServaCibum",

    "header_tagline" =>
        "Community food rescue platform.",

    "slogan" =>
        "Good for People. Better for the Planet.",

    "homepage_description" =>
        "Connecting food donors, volunteers, and charities to reduce food waste and help communities across Sugar Land.",

    "bottom_banner" =>
        "Sharing food with our community.",

    "hero_image_url" =>
        "./assets/servacibum-hero.webp",

    "logo_image_url" =>
        "./assets/servacibum-logo.png"
];


try {

    $row = $pdo->query(
        "SELECT *
         FROM site_settings
         WHERE id = 1"
    )->fetch();

    if ($row) {

        $allowedSettingKeys = [
            "site_name",
            "header_tagline",
            "slogan",
            "homepage_description",
            "hero_image_url",
            "logo_image_url"
        ];

        foreach ($allowedSettingKeys as $key) {

            if (
                array_key_exists($key, $row) &&
                $row[$key] !== null &&
                $row[$key] !== ""
            ) {
                $settings[$key] = $row[$key];
            }
        }
    }

} catch (Throwable $e) {
    // Use the default public settings.
}


/*
|--------------------------------------------------------------------------
| Public response — counts only, no names. Volunteers never returned.
|--------------------------------------------------------------------------
*/

out([
    "restaurants"  => $restaurants,
    "charities"    => $charities,
    "foodListings" => $foodListings,
    "impact"       => $impact,
    "settings"     => $settings
]);
