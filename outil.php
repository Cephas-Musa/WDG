<?php
$connection = new mysqli('localhost', 'root', '', 'wedego'); // Modifier selon vos configurations

$query = "SELECT * FROM sorties";
$result = $connection->query($query);

?>

<div class="container-fluid blog">
    <div class="container" style="height: 900px;">
        <div class="text-center mx-auto pb-5">
            <h1 class="display-5 text-capitalize mb-3" id="title">We.De.Go <span class="text-primary">Blog & News</span></h1>
            <p class="mb-0">Discover our exciting projects...</p>
        </div>
        <div class="row g-4">
            <?php while ($sortie = $result->fetch_assoc()): ?>
                <div class="col-lg-4">
                    <div class="blog-item">
                        <div class="blog-img">
                            <img src="uploads/<?= htmlspecialchars($sortie['image']) ?>"
                                alt="<?= htmlspecialchars($sortie['titre']) ?>"
                                class="img-fluid rounded-top w-100" style="height: 470px; object-fit:cover;">
                        </div>
                        <div class="blog-content rounded-bottom p-4">
                            <div class="blog-date"><?= date('d M Y', strtotime($sortie['date_sortie'])) ?></div>
                            <a href="details.php?id=<?= $sortie['id'] ?>" class="h4 d-block mb-3"><?= $sortie['titre'] ?></a>

                            <p class="description-preview pb-3" style="padding-top: 20px;">
                                <?= nl2br(substr($sortie['description'], 0, 100)) ?>...
                            </p>

                            <a href="details.php?id=<?= $sortie['id'] ?>" class="read-more btn btn-link p-0">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>
