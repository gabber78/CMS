<?php

if (isset($_POST['checkBoxArray'])){

    foreach ($_POST['checkBoxArray'] as $postValueId) {

        $bulk_options = $_POST['bulk_options'];

        switch($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_published_status = mysqli_query($connection, $query);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";
                $update_to_draft_status = mysqli_query($connection, $query);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;

            case 'clone':
                $query = "SELECT *  FROM posts WHERE post_id = '{$postValueId}'";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_date = $row['post_date'];
                    $post_author = $row['post_author'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tag = $row['post_tag'];
                    $post_content = $row['post_content'];
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tag, post_status) 
                            VALUES({$post_category_id}, '{$post_title}', '{$post_author}',now(), '{$post_image}', '{$post_content}', '{$post_tag}', '{$post_status}')";

                $copy_query = mysqli_query($connection, $query);

                if (!$copy_query) {
                    die("Query failed" . mysqli_error($connection));
                }

                break;

        }

    }

}

?>

<form method="post">
<table class="table table-bordered table-hover">

    <div id="bulkOptionsContainer" class="col-xs-4">
        <select name="bulk_options" id="" class="form-control">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>

    </div>

    <div class="col-xs-4">

        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>


    </div>


    <thead>
    <tr>
        <th><input id="selectAllBoxes" type="checkbox"></th>
        <th>Id</th>
        <th>Author</th>
        <th>Title</th>
        <th>Category</th>
        <th>Status</th>
        <th>Image</th>
        <th>Tags</th>
        <th>Comments</th>
        <th>Date</th>
        <th>Views</th>
        <th>View Post</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>

    <tbody>

    <?php
    $query = "SELECT * FROM posts ORDER BY post_id DESC";

    $select_posts = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_posts)) {
        $post_id = $row['post_id'];
        $post_author = $row['post_author'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tag = $row['post_tag'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_views_count = $row['post_views_count'];
        //$post_content = $row['post_content'];

        echo "<tr>";
        ?>

        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?= $post_id ?>'></td>

        <?php

        echo "<td>$post_id</td>";
        echo "<td>$post_author</td>";
        echo "<td>$post_title</td>";

            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<td>{$cat_title}</td>";
            }
        echo "<td>$post_status</td>";
        echo "<td><img class='img-thumbnail' width=200 src='../images/$post_image' alt='post images'></td>";
        echo "<td>$post_tag</td>";


        $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
        $send_comment_query = mysqli_query($connection, $query);

        $row = mysqli_fetch_array($send_comment_query);
        // gives notice error as it is
        //$comment_id = $row['comment_id'];

        //workaround for the notice error:
        if (!isset($row['comment_id'])){
            $row['comment_id'] = NULL;
        }else{
            $comment_id = $row['comment_id'];
        }

        $count_comments = mysqli_num_rows($send_comment_query);

        echo "<td><a href='post_comments.php?id=$post_id' title='View Comments'>$count_comments</a></td>";


        echo "<td>$post_date</td>";
        //reset view count
        echo "<td><a href='posts.php?reset={$post_id}' title='Reset View Count'> $post_views_count</a></td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
        echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
        echo "</tr>";
    }
    ?>

    </tbody>
</table>
</form>

<?php
    if (isset($_GET['delete'])){
        $the_post_id = $_GET['delete'];
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php");

    }

    //reset view count
    if (isset($_GET['reset'])){
        $the_post_id = $_GET['reset'];
        $query = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']);
        $reset_query = mysqli_query($connection, $query);
        header("Location: posts.php");

}
?>