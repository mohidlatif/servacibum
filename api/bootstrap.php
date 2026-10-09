<?php

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
| Public donor summary
|--------------------------------------------------------------------------
|
| Only enough information for the public donor count is returned.
|
*/

$restaurants = $pdo->query(
    "SELECT
        id,
        name,
        status
     FROM restaurants
     WHERE status <> 'archived'
       AND LOWER(TRIM(name)) <> LOWER('ServaCibum Test Food Donor')
     ORDER BY name ASC"
)->fetchAll();


/*
|--------------------------------------------------------------------------
| Public charity summary
|--------------------------------------------------------------------------
|
| Only enough information for the public charity count is returned.
|
*/

$charities = $pdo->query(
    "SELECT
        id,
        status
     FROM charities
     WHERE status <> 'archived'
       AND LOWER(TRIM(name)) <> LOWER('ServaCibum Test Charity')
     ORDER BY id DESC"
)->fetchAll();


/*
|--------------------------------------------------------------------------
| Public food listings
|--------------------------------------------------------------------------
|
| Exact donor street addresses and coordinates are intentionally excluded.
|
*/

$stmt = $pdo->query(
    "SELECT
        d.status,
        d.pickup_date,
        d.pickup_end

     FROM food_donations d
     JOIN restaurants r
       ON r.id = d.restaurant_id

     WHERE d.status = 'available'
       AND COALESCE(
            d.available_quantity,
            d.quantity,
            0
       ) > 0
       AND LOWER(TRIM(r.name)) <> LOWER('ServaCibum Test Food Donor')

     ORDER BY
        d.pickup_date ASC,
        d.id DESC"
);

$foodListings = $stmt->fetchAll();


$foodListings = array_values(
    array_filter(
        $foodListings,
        "donationIsCurrent"
    )
);


/*
|--------------------------------------------------------------------------
| Public browser only needs the number of current available donations
|--------------------------------------------------------------------------
|
| Keep one minimal status object per available donation so the existing
| homepage metric continues to work. Food names, quantities, donor details,
| locations, and pickup timing are not returned publicly.
|
*/

$foodListings = array_map(
    function () {
        return [
            "status" => "available"
        ];
    },
    $foodListings
);


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
        "./assets/servacibum-hero.png",

    "logo_image_url" =>
        "./assets/servacibum-logo.png"
];


/*
|--------------------------------------------------------------------------
| Load only approved public settings
|--------------------------------------------------------------------------
*/

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
| Public response
|--------------------------------------------------------------------------
|
| Volunteer records are deliberately not returned.
|
*/

out([
    "restaurants" => $restaurants,
    "charities" => $charities,
    "foodListings" => $foodListings,
    "settings" => $settings
]);