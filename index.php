<?php
require_once("require/database_connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax CRUD Application</title>
    <style>
    body {
        font-family: cursive;
        background-color: black;
        color: yellow;
    }

    form {
        width: 400px;
        margin: auto;
        padding: 10px;
    }

    label {
        display: block;
        margin-top: 10px;
    }

    input, textarea {
        width: 95%;
        padding: 6px;
        margin-top: 4px;
    }

    button {
        margin-top: 15px;
        padding: 5px;
        border: none;
        cursor: pointer;
        color: black;
        border-radius: 4px;
    }

    button[type="submit"] {
        background-color: #28a745; 
    }
    button[type="submit"]:hover {
        background-color: #218838;
    }

    button[onclick="cancelPost()"] {
        background-color: #dc3545;
    }
    button[onclick="cancelPost()"]:hover {
        background-color: #c82333;
    }

    #search-container button:nth-child(2) {
        background-color: #007bff;
    }
    #search-container button:nth-child(2):hover {
        background-color: #0069d9;
    }

    #search-container button:nth-child(4) {
        background-color: #fd7e14;
        color: black;
    }
    #search-container button:nth-child(4):hover {
        background-color: #e8590c;
    }

    .post-list button {
        padding: 6px 12px;
        margin: 5px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
    }

    .post-list .edit-btn {
        background-color: #6610f2;
        color: white;
    }
    .post-list .edit-btn:hover {
        background-color: #520dc2;
    }

    .post-list .delete-btn {
        background-color: #6c757d;
        color: blue;
    }
    .post-list .delete-btn:hover {
        background-color: #5a6268;
    }

    .post-list {
        margin-top: 20px;
        color: yellow;
        text-align: center;
    }
    .post-list .post {
        background-color: #333;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 5px;
    }
    .post-list .post a {
        color: yellow;
        text-decoration: none;
    }
    .post-list .post a:hover {
        color: orange;
    }

    #search-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }
    #search {
        padding: 8px;
        width: 100%;
    }
    .styled-table {
        width: 100%;
        border-collapse: collapse;
        color: yellow;
        background-color: #222;
        margin-top: 20px;
    }

    .styled-table th, .styled-table td {
        border: 1px solid #444;
        padding: 10px;
        text-align: left;
    }

    .styled-table th {
        background-color: #333;
        color: #ffcc00;
    }

    .styled-table tr:nth-child(even) {
        background-color: #2c2c2c;
    }

    .styled-table tr:hover {
        background-color: #3d3d3d;
    }

    .action-btn {
        padding: 6px 12px;
        border: none;
        color: white;
        cursor: pointer;
        margin-right: 5px;
        border-radius: 4px;
        font-size: 0.9em;
    }

    .edit-btn {
        background-color: #007bff;
    }

    .edit-btn:hover {
        background-color: #0056b3;
    }

    .delete-btn {
        background-color: #dc3545;
    }

    .delete-btn:hover {
        background-color: #a71d2a;
    }
    </style>
    <script type="text/javascript">
        function addOrUpdatePost() {
            var postTitle = document.getElementById("post-title").value;
            var summary = document.getElementById("summary").value;
            var description = document.getElementById("description").value;
            var postId = document.getElementById("post_id").value;

            var action = postId ? "update_post" : "add_post";

            var ajax_request = new XMLHttpRequest();
            ajax_request.onreadystatechange = function () {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    alert(ajax_request.responseText);
                    fetchPosts();
                }
            };
            ajax_request.open("POST", "ajax_process.php", true);
            ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax_request.send("action=" + action + "&post_title=" + postTitle + "&summary=" + summary + "&description=" + description + "&post_id=" + postId);
        }

        function editPost(id, title, summary, description) {
            document.getElementById("post_id").value = id;
            document.getElementById("post-title").value = title;
            document.getElementById("summary").value = summary;
            document.getElementById("description").value = description;
        }

        function deletePost(id) {
            if (confirm("Are you sure you want to delete this post?")) {
                var ajax_request = new XMLHttpRequest();
                ajax_request.onreadystatechange = function () {
                    if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                        alert(ajax_request.responseText);
                        fetchPosts();
                    }
                };
                ajax_request.open("POST", "ajax_process.php", true);
                ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                ajax_request.send("action=delete_post&post_id=" + id);
            }
        }

        function cancelPost() {
            document.getElementById("post-title").value = '';
            document.getElementById("summary").value = '';
            document.getElementById("description").value = '';
            document.getElementById("post_id").value = '';
        }

        function searchPosts() {
            var query = document.getElementById("search").value;
            var ajax_request = new XMLHttpRequest();
            ajax_request.onreadystatechange = function () {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    document.getElementById("post_list").innerHTML = ajax_request.responseText;
                }
            };
            ajax_request.open("POST", "ajax_process.php", true);
            ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax_request.send("action=search_posts&query=" + query);
        }

        function fetchPosts() {
            var ajax_request = new XMLHttpRequest();
            ajax_request.onreadystatechange = function () {
                if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                    document.getElementById("post_list").innerHTML = ajax_request.responseText;
                }
            };
            ajax_request.open("POST", "ajax_process.php", true);
            ajax_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            ajax_request.send("action=fetch_posts");
        }

        window.onload = fetchPosts;
    </script>
</head>
<body>
<h1 align="center">Ajax CRUD Application</h1>

<form onsubmit="addOrUpdatePost(); return false;">
  <input type="hidden" id="post_id">
  <fieldset>
    <legend>Add New Post</legend>
    <table align="center">
      <tr>
        <td><label for="post-title">Post Title:</label></td>
        <td><input type="text" id="post-title" placeholder="Enter post title"></td>
      </tr>
      <tr>
        <td><label for="summary">Summary:</label></td>
        <td><textarea id="summary" placeholder="Enter your summary"></textarea></td>
      </tr>
      <tr>
        <td><label for="description">Description:</label></td>
        <td><textarea id="description" placeholder="Enter post description"></textarea></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align: center;">
          <button type="submit">Add Post</button>
          <button type="button" onclick="cancelPost()">Cancel</button>
        </td>
      </tr>
    </table>
  </fieldset>
</form>
<br/>

<form onsubmit="return false;" class="post-section">
  <fieldset>
    <legend>Search Posts</legend>
    <div id="search-container">
        <input type="text" id="search" onclick="searchPosts()" placeholder="Search...">
        &nbsp;
        <button type="button" onclick="searchPosts()">Search</button>
        &nbsp;
        <button type="button" onclick="fetchPosts()">Show All</button>
    </div>
  </fieldset>
</form>
<!-- <br/> -->
<div class="post-list" id="post_list"></div>

</body>
</html>
