export function haversineMiles(aLat, aLng, bLat, bLng) {
    if ([aLat, aLng, bLat, bLng].some(v => v === null || v === undefined || v === ""))
        return null;
    const R = 3958.7613, rad = x => Number(x) * Math.PI / 180;
    const dLat = rad(bLat - aLat), dLng = rad(bLng - aLng);
    const q = Math.sin(dLat / 2) ** 2 + Math.cos(rad(aLat)) * Math.cos(rad(bLat)) * Math.sin(dLng / 2) ** 2;
    return 2 * R * Math.asin(Math.sqrt(q));
}
export const urgencyPoints = { high: 300, medium: 200, low: 100 };
export function priorityScore(food) {
    const miles = haversineMiles(food.restaurant_lat, food.restaurant_lng, food.charity_lat, food.charity_lng);
    const distancePenalty = miles === null ? 0 : Math.min(miles * 3, 60);
    return Math.round((urgencyPoints[food.urgency] || 0) - distancePenalty);
}
export function bestVolunteer(food, volunteers) {
    const active = volunteers.filter(v => v.status !== "archived" && v.availability === "available");
    if (!active.length)
        return null;
    // ZIP proximity fallback because volunteers only store ZIPs.
    return [...active].sort((a, b) => {
        const az = Math.abs(Number(a.current_zip || 0) - Number(food.restaurant_zip || 0));
        const bz = Math.abs(Number(b.current_zip || 0) - Number(food.restaurant_zip || 0));
        return az - bz;
    })[0];
}
