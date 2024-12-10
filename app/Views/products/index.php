<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Productos</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-3xl font-bold mb-4 text-gray-800">Lista de Productos</h1>
    <table class="min-w-full bg-white rounded-lg shadow-md">
      <thead>
        <tr class="bg-blue-600 text-white text-left">
          <th class="py-2 px-4">ID</th>
          <th class="py-2 px-4">Nombre</th>
          <th class="py-2 px-4">Descripción</th>
          <th class="py-2 px-4">Precio</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
          <tr class="border-b">
            <td class="py-2 px-4"><?= esc($product['id']) ?></td>
            <td class="py-2 px-4"><?= esc($product['name']) ?></td>
            <td class="py-2 px-4"><?= esc($product['description']) ?></td>
            <td class="py-2 px-4"><?= esc($product['price']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
</html>
