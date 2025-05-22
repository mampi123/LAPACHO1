/* ---------- helpers ---------- */
// ► se marca en true después de la primera carga correcta
let productsAlreadyLoaded = false;
// decodifica la parte intermedia del JWT (payload) sin bibliotecas externas
function decodeJwtPayload (token) {
  const payloadBase64 = token.split('.')[1];
  // Base64url → Base64 estándar
  const base64 = payloadBase64.replace(/-/g, '+').replace(/_/g, '/');
  const json = atob(base64);
  return JSON.parse(json);
}

function isTokenValid (token) {
  if (!token) return false;
  try {
    const { exp } = decodeJwtPayload(token);     // fecha Unix (segundos)
    const now = Date.now() / 1000;               // a segundos
    return exp && exp - now > 60;                // 1 min de margen
  } catch (_) {
    return false;
  }
}

/* ---------- obtener token (cache + renovación) ---------- */

const BASE_URL = "https://admin.talabarterialapacho.com";

async function fetchNewToken () {
  console.log('🔄 Pidiendo token nuevo…');
  const res = await fetch(`${BASE_URL}/wp-content/get-jwt-token.php`);
  if (!res.ok) throw new Error('No se pudo obtener token');
  return (await res.text()).trim();
}

async function getToken () {
  const saved = localStorage.getItem('lapacho_jwt');
  if (isTokenValid(saved)) {
    // reutilizamos token en cache
    return saved;
  }

  // venció o no existe → pedimos uno nuevo y lo guardamos
  const fresh = await fetchNewToken();
  localStorage.setItem('lapacho_jwt', fresh);
  return fresh;
}

/* ---------- ejemplo: pedir productos ---------- */

async function getProducts ({ forceReload = false } = {}) {
  if (productsAlreadyLoaded && !forceReload) return;

  const loadingElem = document.querySelector(".loading-state");
  const emptyElem   = document.querySelector(".empty-state");

  if (loadingElem) loadingElem.style.display = "block";
  if (emptyElem)   emptyElem.style.display   = "none";

  const token = await getToken();
  console.log('🐻‍❄ Token usado:', token);

  const res = await fetch(`${BASE_URL}/wp-json/wc/v3/products`, {
    headers: { Authorization: `Bearer ${token}` }
  });

  if (!res.ok) throw new Error(`WooCommerce error ${res.status}`);
  const products = await res.json();
  console.log('📦 Productos', products);

  // Aquí iría la lógica para mostrar los productos en el DOM...
}

/* Más funciones de gestión de productos y carrito ... (puedes añadir las tuyas) */

/* Funciones para agregar al carrito, actualizar cantidad, etc. deben usar BASE_URL igual */
async function addToCart(productId, quantity = 1) {
  showProcessing();
  try {
    const response = await fetch(`${BASE_URL}/?wc-ajax=add_to_cart`, {
      method: "POST",
      mode: "cors",
      credentials: "include",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        product_id: productId,
        quantity: quantity
      })
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();
    console.log("Producto agregado:", data);

    showCartMessage("Producto agregado al carrito");

    updateCartCount();
  } catch (error) {
    console.error("Error al agregar al carrito:", error);
    showCartMessage("❌ Error al agregar al carrito");
  }
  finally {
    hideProcessing();
  }
}

async function updateCartCount () {
  try {
    const token = await getToken();
    if (!token) throw new Error("sin token");

    const res = await fetch(`${BASE_URL}/wp-json/wc/store/cart`, {
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json"
      },
      credentials: "include"
    });

    if (!res.ok) throw new Error(`Woo error ${res.status}`);
    const data = await res.json();

    const count = data.items_count ?? 0;
    document.getElementById("cart-count").textContent = count;
  } catch (err) {
    console.error("❌ Error al obtener el contador de carrito:", err);
  }
}

/* Funciones UI auxiliares */
function showProcessing() {
  const overlay = document.getElementById("processing-overlay");
  if (overlay) overlay.style.display = "block";
}

function hideProcessing() {
  const overlay = document.getElementById("processing-overlay");
  if (overlay) overlay.style.display = "none";
}

function showCartMessage(message) {
  const messageDiv = document.getElementById("cart-message");
  if (!messageDiv) return;

  messageDiv.textContent = message;
  messageDiv.style.display = "block";
  messageDiv.style.opacity = "1";

  setTimeout(() => {
    messageDiv.style.opacity = "0";
    setTimeout(() => {
      messageDiv.style.display = "none";
      messageDiv.style.opacity = "1";
    }, 300);
  }, 3000);
}

/* Inicio */
document.addEventListener("DOMContentLoaded", () => {
  updateCartCount();
  getProducts();
});
