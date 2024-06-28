<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
</head>
<body>
    <form action="/compress-image" method="post" enctype="multipart/form-data">
        @csrf
        <label for="image">Choose image to upload</label>
        <input type="file" name="image" id="image">
        <button type="submit">Upload and Compress</button>
    </form>
</body>
</html>