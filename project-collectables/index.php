<?php
session_start();
require_once 'db.php';

$search = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'newest';

$sql = "
SELECT
    c.id,
    c.name,
    c.description,
    c.cover_url,

    u.name AS owner,

    COUNT(i.id) AS total_items

FROM collections c

INNER JOIN users u
    ON u.id = c.user_id

LEFT JOIN items i
    ON i.collection_id = c.id

WHERE 1=1
";

$params = [];

if (!empty($search)) {

    $sql .= "

    AND (

        c.name LIKE ?
        OR c.description LIKE ?

    )

    ";

    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
}
if (!empty($category)) {

    $sql .= "

    AND EXISTS (

        SELECT 1
        FROM items x

        WHERE x.collection_id = c.id
        AND x.category = ?

    )

    ";

    $params[] = $category;
}

switch($sort){

    case 'az':
        $orderBy = 'c.name ASC';
        break;

    case 'za':
        $orderBy = 'c.name DESC';
        break;

    case 'oldest':
        $orderBy = 'c.created_at ASC';
        break;

    default:
        $orderBy = 'c.created_at DESC';
}

$sql .= "

GROUP BY c.id

ORDER BY {$orderBy}

";



$categoriesStmt = $pdo->query("

SELECT DISTINCT category

FROM items

WHERE category IS NOT NULL

ORDER BY category

");

$categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$collections = $stmt->fetchAll(PDO::FETCH_ASSOC); 

?>

<!DOCTYPE html>
<html lang="nl">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Collectables</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="css/style.css">

</head>

<body>

<nav class="navbar navbar-expand navbar-custom">

    <div class="container">


        <a
            href="index.php"
            class="navbar-brand d-flex align-items-center gap-2">

            <div class="logo-box">

                <i class="bi bi-box-seam"></i>

            </div>

            <span class="fw-bold fs-5">

                COLLECTABLES

            </span>

        </a>


        <ul class="navbar-nav mx-auto flex-row gap-5">

            <li class="nav-item">

                <a
                    href="index.php"
                    class="nav-link active">

                    HOME

                </a>

            </li>

            <li class="nav-item">

                <a
                    href="collectable-page.php"
                    class="nav-link">

                    VERZAMELINGEN

                </a>

            </li>

            <li class="nav-item">

                <a
                    href="mijn-verzamelingen.php"
                    class="nav-link">

                    MIJN VERZAMELINGEN

                </a>

            </li>

        </ul>

    

        <div class="d-flex align-items-center gap-3">

            <form
                method="GET"
                class="search-wrapper">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Zoeken..."
                    value="<?= htmlspecialchars($search) ?>">

                <button
                    type="submit"
                    class="search-btn">

                    <i class="bi bi-search"></i>

                </button>

            </form>

            <?php if (isset($_SESSION['user_id'])): ?>

            <a
                href="profile.php"
                class="btn btn-outline-secondary d-flex align-items-center gap-2 profile-btn">

                <span class="profile-icon">
                    <i class="bi bi-person-circle"></i>
                </span>

                <span class="d-none d-lg-inline">
                    <?= htmlspecialchars($_SESSION['user_name']) ?>
                </span>

            </a>

            <?php else: ?>

            <a
                href="inlog.php"
                class="btn btn-outline-secondary">

                INLOGGEN

            </a>

            <a
                href="registration.php"
                class="btn btn-primary">

                REGISTREREN

            </a>

            <?php endif; ?>

        </div>

    </div>

</nav>

<section class="hero">

    <div class="container">

        <div class="row align-items-center">


            <div class="col-lg-5">

                <h1 class="hero-title">

                    WELKOM BIJ
                    COLLECTABLES

                </h1>

                <p class="hero-text mt-4">

                    Dé plek om jouw verzamelingen te beheren,
                    te delen en nieuwe collecties te ontdekken.

                </p>

                <div class="d-flex gap-3 mt-4">

                    <a
                        href="mijn-verzamelingen.php"
                        class="btn btn-primary btn-lg">

                        BEKIJK VERZAMELINGEN

                    </a>

                </div>

            </div>


            <div class="col-lg-7">

                <div class="hero-image">

                    <img
                        src="img/hero.png"
                        alt="Collectables Showcase"
                        class="img-fluid rounded-4">

                </div>

            </div>

        </div>

    </div>

</section>

<section class="mb-5">

    <div class="container">

        <div class="filter-box">

            <form method="GET">

                <div class="row g-3">



                    <div class="col-lg-5">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Zoek verzamelingen..."
                            value="<?= htmlspecialchars($search) ?>">

                    </div>


                    <div class="col-lg-3">

                        <select
                            name="category"
                            class="form-select">

                            <option value="">
                                Alle categorieën
                            </option>

                            <?php foreach($categories as $cat): ?>

                                <option
                                    value="<?= htmlspecialchars($cat) ?>"
                                    <?= $category === $cat ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($cat) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <div class="col-lg-3">

                        <select
                            name="sort"
                            class="form-select">

                            <option
                                value="newest"
                                <?= $sort === 'newest' ? 'selected' : '' ?>>

                                Nieuwste eerst

                            </option>

                            <option
                                value="oldest"
                                <?= $sort === 'oldest' ? 'selected' : '' ?>>

                                Oudste eerst

                            </option>

                            <option
                                value="az"
                                <?= $sort === 'az' ? 'selected' : '' ?>>

                                A-Z

                            </option>

                            <option
                                value="za"
                                <?= $sort === 'za' ? 'selected' : '' ?>>

                                Z-A

                            </option>

                        </select>

                    </div>


                    <div class="col-lg-1">

                        <button
                            class="btn btn-primary w-100">

                            Go

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>

<section id="collections" class="py-5">

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">
                POPULAIRE VERZAMELINGEN
            </h2>

            <a href="collectables-page.php" class="text-decoration-none">
                Bekijk alle verzamelingen →
            </a>

        </div>

        <div class="row g-4">
                            
            <?php foreach($collections as $collection): ?>

                <div class="col-lg-4">

                <a href="collectable-page.php?id=<?= $collection['id'] ?>"
                     class="text-decoration-none text-dark">

                    <div class="card collection-card h-100">

                        <?php if(!empty($collection['cover_url'])): ?>

                            <img
                                src="<?= htmlspecialchars($collection['cover_url']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($collection['name']) ?>">

                        <?php else: ?>

                            <div class="card-image d-flex align-items-center justify-content-center">

                                <i class="bi bi-image fs-1 text-secondary"></i>

                            </div>

                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title">

                                <?= htmlspecialchars($collection['name']) ?>

                            </h5>

                            <p class="text-secondary mb-2">

                                door
                                <?= htmlspecialchars($collection['owner']) ?>

                            </p>

                            <p class="card-text">

                                <?= htmlspecialchars($collection['description']) ?>

                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">

                            <small class="text-muted">

                                <i class="bi bi-collection"></i>

                                <?= $collection['total_items'] ?>
                                items

                            </small>

                        </div>

                    </div>
                        
                </a>

             </div>

        <?php endforeach; ?>

    </div>

</div>

</section>

<section class="features py-5">

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-3">

                <div class="d-flex gap-3">

                    <div class="feature-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <div>

                        <h5>
                            MAAK JE EIGEN VERZAMELING
                        </h5>

                        <p class="text-secondary mb-0">
                            Maak eenvoudig je eigen collecties aan.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="d-flex gap-3">

                    <div class="feature-icon">

                        <i class="bi bi-cloud-upload"></i>

                    </div>

                    <div>

                        <h5>
                            VOEG ITEMS TOE
                        </h5>

                        <p class="text-secondary mb-0">
                            Beheer al je verzamelobjecten op één plek.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="d-flex gap-3">

                    <div class="feature-icon">

                        <i class="bi bi-heart"></i>

                    </div>

                    <div>

                        <h5>
                            DEEL & ONTDEK
                        </h5>

                        <p class="text-secondary mb-0">
                            Ontdek collecties van andere verzamelaars.
                        </p>

                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <div class="d-flex gap-3">

                    <div class="feature-icon">

                        <i class="bi bi-shield-check"></i>

                    </div>

                    <div>

                        <h5>
                            VEILIG & BETROUWBAAR
                        </h5>

                        <p class="text-secondary mb-0">
                            Je gegevens blijven veilig opgeslagen.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<footer>

    <div class="container">

        <div class="row g-4">

            

            <div class="col-lg-4">

                <div class="d-flex align-items-center gap-2 mb-3">

                    <div class="logo-box">

                        <i class="bi bi-box-seam"></i>

                    </div>

                    <span class="fw-bold fs-5 text-white">

                        COLLECTABLES

                    </span>

                </div>

                <p class="text-light">

                    Dé plek om verzamelingen te beheren,
                    ontdekken en delen met andere verzamelaars.

                </p>

            </div>

           

            <div class="col-lg-2">

                <h5 class="mb-3">
                    Navigatie
                </h5>

                <a href="index.php">
                    Home
                </a>

                <a href="#">
                    Verzamelingen
                </a>

                <a href="#">
                    Mijn Verzamelingen
                </a>

            </div>

         

            <div class="col-lg-3">

                <h5 class="mb-3">
                    Informatie
                </h5>

                <a href="#">
                    Over Ons
                </a>

                <a href="#">
                    Contact
                </a>

                <a href="#">
                    Privacybeleid
                </a>

            </div>

           

            <div class="col-lg-3">

                <h5 class="mb-3">
                    Volg Ons
                </h5>

                <div class="d-flex gap-3">

                    <i class="bi bi-instagram fs-4"></i>

                    <i class="bi bi-facebook fs-4"></i>

                    <i class="bi bi-twitter-x fs-4"></i>

                </div>

            </div>

        </div>

        <hr class="my-4 footer-line">

        <div class="text-center">

            © <?= date('Y') ?> Collectables.
            Alle rechten voorbehouden.

        </div>

    </div>

</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>