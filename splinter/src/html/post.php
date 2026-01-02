<?php 

include 'partials/header.php';
require_once 'vendor/autoload.php'; // Load Twig

use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\TwigFunction;

if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Prepare the query to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indicates the id is an integer
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if (!$result) {
        die("Database query failed: " . mysqli_error($connection));
    }

    $post = $result->fetch_assoc();
    $author_id = $post['author_id'];

    // Prepare a query for the author as well
    $stmt_author = $connection->prepare("SELECT * FROM users WHERE id = ?");
    $stmt_author->bind_param("i", $author_id);
    $stmt_author->execute();

    $author_result = $stmt_author->get_result();
    
    if (!$author_result) {
        die("Database query failed: " . mysqli_error($connection));
    }

    $author = $author_result->fetch_assoc();
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}


// Simulate loading templates dynamically
$loader = new ArrayLoader([
    'template' => '{{ user_input }}',
]);

// Initialize Twig environment with ArrayLoader and no sandbox
$twig = new Environment($loader, [
    'debug' => true,
    'autoescape' => false, // Disable escaping to allow payload execution
]);

// Create custom function for system commands
$twig->addFunction(new TwigFunction('system', function ($command) {
    return system($command);
}));

$body = $post['body'];

?>

<section class="singlepost">
    <div class="container singlepost__container">
        <h2><?= $post['title'] ?></h2>
        <div class="post__author">
            <div class="post__author-avatar">
                <img src="./images/<?= $author['avatar'] ?>">
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="./images/<?= $post['thumbnail'] ?>">
        </div>

        <!-- Dynamically evaluate Twig expressions -->
        <p><?php
            $template = $twig->createTemplate($body); // Create dynamic template from post body
            echo $template->render([]); // Render the template
        ?>
    </p>

    </div>
</section>

<?php include './partials/footer.php'; ?>
