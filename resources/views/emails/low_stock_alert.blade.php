<!DOCTYPE html>
<html>
<head>
    <title>Low Stock Alert</title>
</head>
<body>
<h2>Low Stock Alert: {{ $ingredient->name }}</h2>
<p>The stock level for {{ $ingredient->name }} has dropped below 50%.</p>
<p>Current Stock: {{ $ingredient->stock }}</p>
<p>Please restock soon to avoid running out!</p>
</body>
</html>
