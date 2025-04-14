<?php
require_once("require/database_connection.php");

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // === ADD POST ===
    if ($action == 'add_post') {
        if (isset($_POST['post_title'], $_POST['summary'], $_POST['description'])) {
            $title = trim($_POST['post_title']);
            $summary = trim($_POST['summary']);
            $description = trim($_POST['description']);

            if ($title !== '' && $summary !== '' && $description !== '') {
                $query = "INSERT INTO posts (title, summary, description) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sss", $title, $summary, $description);

                echo mysqli_stmt_execute($stmt) ? "Post added successfully!" : "Error adding post!";
                mysqli_stmt_close($stmt);
            } else {
                echo "Please fill in all fields!";
            }
        } else {
            echo "Missing post data!";
        }
    }

    // === UPDATE POST ===
    if ($action == 'update_post') {
        if (isset($_POST['post_id'], $_POST['post_title'], $_POST['summary'], $_POST['description'])) {
            $id = (int) $_POST['post_id'];
            $title = trim($_POST['post_title']);
            $summary = trim($_POST['summary']);
            $description = trim($_POST['description']);

            if ($title !== '' && $summary !== '' && $description !== '') {
                $query = "UPDATE posts SET title = ?, summary = ?, description = ? WHERE id = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sssi", $title, $summary, $description, $id);

                echo mysqli_stmt_execute($stmt) ? "Post updated successfully!" : "Error updating post!";
                mysqli_stmt_close($stmt);
            } else {
                echo "Please fill in all fields!";
            }
        } else {
            echo "Missing post data!";
        }
    }

    // === DELETE POST ===
    if ($action == 'delete_post') {
        if (isset($_POST['post_id'])) {
            $id = (int) $_POST['post_id'];

            $query = "DELETE FROM posts WHERE id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $id);

            echo mysqli_stmt_execute($stmt) ? "Post deleted successfully!" : "Error deleting post!";
            mysqli_stmt_close($stmt);
        } else {
            echo "Post ID is missing!";
        }
    }

    // === SEARCH POSTS ===
    if ($action == 'search_posts') {
        $query = isset($_POST['query']) ? trim($_POST['query']) : '';
        $searchQuery = "SELECT * FROM posts WHERE title LIKE ? OR summary LIKE ?";
        $stmt = mysqli_prepare($connection, $searchQuery);
        $searchTerm = "%" . $query . "%";
        mysqli_stmt_bind_param($stmt, "ss", $searchTerm, $searchTerm);

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1' width='100%' style='color: white; border-collapse: collapse; text-align: left;'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Summary</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>";
            while ($data = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$data['id']}</td>
                        <td>{$data['title']}</td>
                        <td>{$data['summary']}</td>
                        <td>{$data['description']}</td>
                        <td>
                            <button onclick=\"editPost('{$data['id']}', '{$data['title']}', '{$data['summary']}', '{$data['description']}')\">Edit</button>
                            <button onclick=\"deletePost('{$data['id']}')\">Delete</button>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No posts found.";
        }

        mysqli_stmt_close($stmt);
    }

    // === FETCH ALL POSTS ===
    if ($action == 'fetch_posts') {
        $query = "SELECT * FROM posts";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='styled-table'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Summary</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['summary']}</td>
                        <td>{$row['description']}</td>
                        <td>
                            <button onclick=\"editPost('{$row['id']}', '{$row['title']}', '{$row['summary']}', '{$row['description']}')\">Edit</button>
                            &nbsp;
                            <button onclick=\"deletePost('{$row['id']}')\">Delete</button>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "No posts available.";
        }
    }
}
?>
