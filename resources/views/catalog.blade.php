<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McMaster-Carr Clone</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <div class="grid-container">

        <header class="top-bar">
            <div class="logo">
                <span>McMaster-Carr</span>
            </div>
            <div class="search-container">
                <input type="search" placeholder="Search">
                <button type="submit">🔍</button>
            </div>
            <div class="header-buttons">
                <a href="#">Order</a>
                <a href="#">Login/Register</a>
            </div>
        </header>

        <aside class="left-sidebar">
            <h3>Choose a category</h3>
            <hr>
            <ul>
                <li><a href="#">Fastening & Joining</a></li>
                <li><a href="#">Piping, Tubing, Hose & Fittings</a></li>
                <li><a href="#">Sealing</a></li>
                <li><a href="#">Hardware</a></li>
                <li><a href="#">Abrasives</a></li>
                <li><a href="#">Adhesives</a></li>
                <li><a href="#">Building & Grounds</a></li>
                <li><a href="#">Electrical & Lighting</a></li>
            </ul>
        </aside>

<main class="main-content">
    <div class="top-content-border"></div>

    <div class="page-links">
        <span>All Categories<span>
        <hr>
    </div>

    <h1 class="main-category-title">Fastening & Joining</h1>

    <div class="category-groups-container">

        <div class="category-group">
            <h4>Fasteners</h4>
            <div class="item-grid">
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Screws & Bolts</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Threaded Rods</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>U-Bolts</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Nuts</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Washers</p>
                </div>
            </div>
        </div>

        <div class="category-group">
            <h4>Adhesives & Tape</h4>
            <div class="item-grid">
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Adhesives</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Tape</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Hook & Loop</p>
                </div>
            </div>
        </div>

        <div class="category-group">
            <h4>Welding, Brazing & Soldering</h4>
            <div class="item-grid">
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Electrodes</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Welders</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Gas Regulators</p>
                </div>
                <div class="item-card">
                    <img src="https://placehold.co/150" alt="Item Image">
                    <p>Welding Gloves</p>
                </div>
            </div>
        </div>

    </div> </main>

    </div>

</body>
</html>
