const API = "./api";
async function request(path, options = {}) {
    const r = await fetch(`${API}/${path}`, { headers: { "Content-Type": "application/json", ...(options.headers || {}) }, ...options });
    const data = await r.json();
    if (!r.ok)
        throw new Error(data.error || "Request failed");
    return data;
}
export const api = {
    bootstrap: () => request("bootstrap.php"),
    create: (resource, data) => request(`${resource}.php`, { method: "POST", body: JSON.stringify(data) }),
    update: (resource, data) => request(`${resource}.php`, { method: "PUT", body: JSON.stringify(data) }),
    log: (message) => request("logs.php", { method: "POST", body: JSON.stringify({ message }) })
};
