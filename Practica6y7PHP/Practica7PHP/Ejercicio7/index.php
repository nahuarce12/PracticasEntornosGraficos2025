<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda Online - Ejercicio 7</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      padding: 20px;
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      backdrop-filter: blur(10px);
      animation: slideIn 0.6s ease-out;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-30px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .header {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 40px 30px;
      text-align: center;
      position: relative;
    }

    .header h1 {
      font-size: 3em;
      margin-bottom: 15px;
      font-weight: 600;
    }

    .header p {
      font-size: 1.3em;
      opacity: 0.9;
    }

    .cart-badge {
      position: absolute;
      top: 30px;
      right: 30px;
      background: #ff6b6b;
      color: white;
      padding: 15px 25px;
      border-radius: 30px;
      font-size: 1.2em;
      font-weight: bold;
      box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .cart-badge:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
    }

    .cart-badge .count {
      background: white;
      color: #ff6b6b;
      padding: 5px 12px;
      border-radius: 20px;
      margin-left: 10px;
      font-size: 1.1em;
    }

    .content {
      padding: 40px;
    }

    .intro {
      background: #e8f4f8;
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
      border-left: 5px solid #667eea;
    }

    .intro h3 {
      color: #0c5460;
      margin-bottom: 15px;
      font-size: 1.4em;
    }

    .intro p {
      color: #0c5460;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .database-info {
      background: #fff3cd;
      padding: 25px;
      border-radius: 12px;
      margin: 25px 0;
      border: 1px solid #ffeaa7;
    }

    .database-info h4 {
      color: #856404;
      margin-bottom: 15px;
      font-size: 1.3em;
    }

    .database-info p {
      color: #856404;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
      margin: 30px 0;
    }

    .product-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .product-image {
      width: 100%;
      height: 200px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4em;
      position: relative;
    }

    .product-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #28a745;
      color: white;
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.7em;
      font-weight: bold;
      text-transform: uppercase;
    }

    .product-info {
      padding: 20px;
    }

    .product-name {
      font-size: 1.3em;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
    }

    .product-description {
      color: #666;
      font-size: 0.9em;
      line-height: 1.5;
      margin-bottom: 15px;
      min-height: 60px;
    }

    .product-category {
      display: inline-block;
      background: #e9ecef;
      color: #666;
      padding: 5px 12px;
      border-radius: 15px;
      font-size: 0.8em;
      margin-bottom: 10px;
    }

    .product-price {
      font-size: 1.8em;
      font-weight: bold;
      color: #667eea;
      margin: 15px 0;
    }

    .product-stock {
      color: #666;
      font-size: 0.9em;
      margin-bottom: 15px;
    }

    .product-actions {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    .quantity-selector {
      display: flex;
      align-items: center;
      gap: 10px;
      background: #f8f9fa;
      padding: 8px 12px;
      border-radius: 25px;
    }

    .quantity-selector button {
      background: #667eea;
      color: white;
      border: none;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      cursor: pointer;
      font-size: 1.2em;
      transition: all 0.3s ease;
    }

    .quantity-selector button:hover {
      background: #764ba2;
      transform: scale(1.1);
    }

    .quantity-selector input {
      width: 50px;
      text-align: center;
      border: none;
      background: transparent;
      font-size: 1.1em;
      font-weight: bold;
    }

    .btn {
      display: inline-block;
      padding: 12px 25px;
      text-decoration: none;
      border-radius: 25px;
      font-weight: bold;
      transition: all 0.3s ease;
      font-size: 1em;
      text-transform: uppercase;
      letter-spacing: 1px;
      border: none;
      cursor: pointer;
      text-align: center;
    }

    .btn-add {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
      flex: 1;
    }

    .btn-add:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .btn-primary {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-success {
      background: linear-gradient(45deg, #28a745, #20c997);
      color: white;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .btn-success:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
    }

    .btn-secondary {
      background: linear-gradient(45deg, #6c757d, #495057);
      color: white;
      box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }

    .btn-secondary:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
    }

    .actions {
      text-align: center;
      margin-top: 40px;
      padding-top: 30px;
      border-top: 2px solid #e9ecef;
    }

    .alert {
      padding: 20px;
      margin: 20px 0;
      border-radius: 10px;
      border-left: 5px solid;
      animation: fadeIn 0.5s ease-out;
    }

    .alert-success {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .alert-info {
      background: #cce7ff;
      border-color: #667eea;
      color: #0c5460;
    }

    .alert-warning {
      background: #fff3cd;
      border-color: #ffc107;
      color: #856404;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }

      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin: 30px 0;
    }

    .feature-card {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
      text-align: center;
      transition: transform 0.3s ease;
      border-top: 4px solid #667eea;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      font-size: 2.5em;
      margin-bottom: 15px;
      display: block;
    }

    .feature-card h4 {
      color: #333;
      margin-bottom: 10px;
      font-size: 1.2em;
    }

    .feature-card p {
      color: #666;
      line-height: 1.5;
      font-size: 0.95em;
    }

    @media (max-width: 768px) {
      .header h1 {
        font-size: 2.2em;
      }

      .content {
        padding: 25px;
      }

      .products-grid {
        grid-template-columns: 1fr;
      }

      .cart-badge {
        position: static;
        margin: 20px auto;
        display: inline-block;
      }
    }

    .loading {
      text-align: center;
      padding: 60px;
      color: #666;
    }

    .loading-spinner {
      width: 50px;
      height: 50px;
      border: 5px solid #f3f3f3;
      border-top: 5px solid #667eea;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin: 0 auto 20px;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="header">
      <h1>🛒 Tienda Online</h1>
      <p>Ejercicio 7 - Sistema de Carrito de Compras con Base de Datos</p>
      <a href="ver_carrito.php" class="cart-badge">
        🛒 Carrito <span class="count" id="cartCount">0</span>
      </a>
    </div>

    <div class="content">
      <div class="intro">
        <h3>🎯 Bienvenido a Nuestra Tienda Virtual</h3>
        <p>
          Explora nuestro catálogo de productos y agrega tus favoritos al carrito de compras.
          Este sistema utiliza sesiones PHP para mantener tu carrito y una base de datos MySQL
          para gestionar el inventario de productos.
        </p>
      </div>

      <div class="database-info">
        <h4>⚠️ Configuración Requerida</h4>
        <p>
          <strong>Base de Datos:</strong> Compras<br>
          <strong>Tabla:</strong> catalogo<br>
          Si es la primera vez que usas este sistema, haz clic en el botón de configuración para crear la base de datos automáticamente.
        </p>
        <div style="text-align: center; margin-top: 15px;">
          <a href="configurar_bd.php" class="btn btn-secondary">
            🛠️ Configurar Base de Datos
          </a>
        </div>
      </div>

      <div class="features">
        <div class="feature-card">
          <span class="feature-icon">🗄️</span>
          <h4>Base de Datos MySQL</h4>
          <p>Productos almacenados en base de datos 'Compras' con gestión completa de inventario</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">🛒</span>
          <h4>Carrito Persistente</h4>
          <p>Tu carrito se mantiene durante toda la sesión usando $_SESSION de PHP</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">💰</span>
          <h4>Cálculo Automático</h4>
          <p>El sistema calcula subtotales, totales e IVA automáticamente</p>
        </div>

        <div class="feature-card">
          <span class="feature-icon">📦</span>
          <h4>Gestión de Stock</h4>
          <p>Control de inventario en tiempo real para evitar sobreventa</p>
        </div>
      </div>

      <div id="productsContainer">
        <div class="loading">
          <div class="loading-spinner"></div>
          <h3>Cargando productos...</h3>
          <p>Por favor espera mientras cargamos el catálogo</p>
        </div>
      </div>

      <div class="actions">
        <a href="ver_carrito.php" class="btn btn-success">
          🛒 Ver Mi Carrito
        </a>
        <a href="productos.php" class="btn btn-primary">
          📦 Recargar Productos
        </a>
        <a href="../index.php" class="btn btn-secondary">
          🏠 Menú Principal
        </a>
      </div>
    </div>
  </div>

  <script>
    // Cargar productos desde el servidor
    async function cargarProductos() {
      try {
        const response = await fetch('productos.php');
        const data = await response.json();

        if (data.error) {
          document.getElementById('productsContainer').innerHTML = `
                        <div class="alert alert-warning">
                            <strong>⚠️ Error:</strong> ${data.error}
                            <br><br>
                            <a href="configurar_bd.php" class="btn btn-secondary">🛠️ Configurar Base de Datos</a>
                        </div>
                    `;
          return;
        }

        if (data.productos && data.productos.length > 0) {
          mostrarProductos(data.productos);
          actualizarContadorCarrito();
        } else {
          document.getElementById('productsContainer').innerHTML = `
                        <div class="alert alert-info">
                            <strong>ℹ️ Información:</strong> No hay productos disponibles en el catálogo.
                            <br><br>
                            <a href="configurar_bd.php" class="btn btn-secondary">🛠️ Configurar Base de Datos</a>
                        </div>
                    `;
        }
      } catch (error) {
        document.getElementById('productsContainer').innerHTML = `
                    <div class="alert alert-warning">
                        <strong>⚠️ Error de conexión:</strong> No se pudieron cargar los productos.
                        Asegúrate de que el servidor esté funcionando correctamente.
                    </div>
                `;
      }
    }

    function mostrarProductos(productos) {
      const grid = document.createElement('div');
      grid.className = 'products-grid';

      productos.forEach(producto => {
        const card = crearTarjetaProducto(producto);
        grid.appendChild(card);
      });

      document.getElementById('productsContainer').innerHTML = '';
      document.getElementById('productsContainer').appendChild(grid);
    }

    function crearTarjetaProducto(producto) {
      const div = document.createElement('div');
      div.className = 'product-card';
      div.innerHTML = `
                <div class="product-image">
                    ${producto.emoji || '📦'}
                    ${producto.stock > 0 ? '<span class="product-badge">Disponible</span>' : '<span class="product-badge" style="background: #dc3545;">Agotado</span>'}
                </div>
                <div class="product-info">
                    <span class="product-category">${producto.categoria}</span>
                    <div class="product-name">${producto.nombre}</div>
                    <div class="product-description">${producto.descripcion}</div>
                    <div class="product-price">$${parseFloat(producto.precio).toFixed(2)}</div>
                    <div class="product-stock">📦 Stock: ${producto.stock} unidades</div>
                    <div class="product-actions">
                        <div class="quantity-selector">
                            <button onclick="cambiarCantidad(${producto.id}, -1)">-</button>
                            <input type="number" id="qty-${producto.id}" value="1" min="1" max="${producto.stock}" readonly>
                            <button onclick="cambiarCantidad(${producto.id}, 1)">+</button>
                        </div>
                        <button class="btn btn-add" onclick="agregarAlCarrito(${producto.id})" ${producto.stock <= 0 ? 'disabled' : ''}>
                            ${producto.stock > 0 ? '🛒 Agregar' : 'Agotado'}
                        </button>
                    </div>
                </div>
            `;
      return div;
    }

    function cambiarCantidad(id, cambio) {
      const input = document.getElementById(`qty-${id}`);
      let valor = parseInt(input.value) + cambio;
      const max = parseInt(input.max);

      if (valor < 1) valor = 1;
      if (valor > max) valor = max;

      input.value = valor;
    }

    async function agregarAlCarrito(id) {
      const cantidadInput = document.getElementById(`qty-${id}`);
      const cantidad = cantidadInput.value;

      try {
        const formData = new FormData();
        formData.append('producto_id', id);
        formData.append('cantidad', cantidad);

        const response = await fetch('agregar_carrito.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.success) {
          mostrarNotificacion('✅ Producto agregado al carrito', 'success');
          actualizarContadorCarrito();
          cantidadInput.value = 1;
        } else {
          mostrarNotificacion('❌ ' + (data.error || 'Error al agregar producto'), 'error');
        }
      } catch (error) {
        mostrarNotificacion('❌ Error de conexión', 'error');
      }
    }

    async function actualizarContadorCarrito() {
      try {
        const response = await fetch('obtener_carrito.php');
        const data = await response.json();

        if (data.items) {
          let totalItems = 0;
          data.items.forEach(item => {
            totalItems += parseInt(item.cantidad);
          });
          document.getElementById('cartCount').textContent = totalItems;
        }
      } catch (error) {
        console.error('Error al actualizar contador:', error);
      }
    }

    function mostrarNotificacion(mensaje, tipo) {
      const div = document.createElement('div');
      div.className = `alert alert-${tipo === 'success' ? 'success' : 'warning'}`;
      div.innerHTML = `<strong>${mensaje}</strong>`;
      div.style.position = 'fixed';
      div.style.top = '20px';
      div.style.right = '20px';
      div.style.zIndex = '9999';
      div.style.minWidth = '300px';

      document.body.appendChild(div);

      setTimeout(() => {
        div.style.opacity = '0';
        div.style.transition = 'opacity 0.5s';
        setTimeout(() => div.remove(), 500);
      }, 3000);
    }

    // Cargar productos al inicio
    cargarProductos();
  </script>
</body>

</html>