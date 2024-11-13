<select class="form-control" name="category" id="category">
    <option value="">Select A Category</option>
    <?php
    // Include the database connection file
    include("./common/db.php");

    // Fetch categories from the database
    $query = "SELECT * FROM category"; // Ensure your table name is correct (check for plural/singular)
    $result = $conn->query($query);

    // Loop through and display categories as options
    if ($result && $result->num_rows > 0) {
        foreach ($result as $row) {
            $name = ucfirst($row['name']); // Capitalize the category name
            $id = $row['id']; // Category ID
            echo "<option value='$id'>$name</option>"; // Create an option tag for each category
        }
    } else {
        echo "<option value=''>No categories available</option>"; // Show a default message if no categories are found
    }
    ?>
</select>
