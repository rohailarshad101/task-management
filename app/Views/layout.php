<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?? 'Task Management' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
    <script src="<?= base_url() ?>vendors/js/jquery.min.js"></script>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");
        :root{--header-height: 3rem;--nav-width: 68px;--first-color: #4723D9;--first-color-light: #AFA5D9;--white-color: #F7F6FB;--body-font: 'Nunito', sans-serif;--normal-font-size: 1rem;--z-fixed: 100}*,::before,::after{box-sizing: border-box}body{position: relative;margin: var(--header-height) 0 0 0;padding: 0 1rem;font-family: var(--body-font);font-size: var(--normal-font-size);transition: .5s}a{text-decoration: none}.header{width: 100%;height: var(--header-height);position: fixed;top: 0;left: 0;display: flex;align-items: center;justify-content: space-between;padding: 0 1rem;background-color: var(--white-color);z-index: var(--z-fixed);transition: .5s}.header_toggle{color: var(--first-color);font-size: 1.5rem;cursor: pointer}.header_img{width: 35px;height: 35px;display: flex;justify-content: center;border-radius: 50%;overflow: hidden}.header_img img{width: 40px}.l-navbar{position: fixed;top: 0;left: -30%;width: var(--nav-width);height: 100vh;background-color: var(--first-color);padding: .5rem 1rem 0 0;transition: .5s;z-index: var(--z-fixed)}.nav{height: 100%;display: flex;flex-direction: column;justify-content: space-between;overflow: hidden}.nav_logo, .nav_link{display: grid;grid-template-columns: max-content max-content;align-items: center;column-gap: 1rem;padding: .5rem 0 .5rem 1.5rem}.nav_logo{margin-bottom: 2rem}.nav_logo-icon{font-size: 1.25rem;color: var(--white-color)}.nav_logo-name{color: var(--white-color);font-weight: 700}.nav_link{position: relative;color: var(--first-color-light);margin-bottom: 1.5rem;transition: .3s}.nav_link:hover{color: var(--white-color)}.nav_icon{font-size: 1.25rem}.show{left: 0}.body-pd{padding-left: calc(var(--nav-width) + 1rem)}.active{color: var(--white-color)}.active::before{content: '';position: absolute;left: 0;width: 2px;height: 32px;background-color: var(--white-color)}.height-100{height:100vh}@media screen and (min-width: 768px){body{margin: calc(var(--header-height) + 1rem) 0 0 0;padding-left: calc(var(--nav-width) + 2rem)}.header{height: calc(var(--header-height) + 1rem);padding: 0 2rem 0 calc(var(--nav-width) + 2rem)}.header_img{width: 40px;height: 40px}.header_img img{width: 45px}.l-navbar{left: 0;padding: 1rem 1rem 0 0}.body-pd{padding-left: calc(var(--nav-width) + 188px)}}
    </style>
    <style>
        body {
            display: flex;
        }
        .sidebar {
            height: 100%;
            width: 250px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            transition: width 0.3s;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #0056b3;
        }
        .sidebar .sidebar-header {
            padding: 15px;
            font-size: 1.2rem;
            text-align: center;
            background-color: #0056b3;
        }
        .sidebar .collapse-btn {
            width: 100%;
            text-align: center;
            background-color: #0056b3;
            border: none;
            color: #fff;
            padding: 10px 0;
            cursor: pointer;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
        }
        .content.collapsed {
            margin-left: 80px;
            width: calc(100% - 80px);
        }

        #loader {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        #loader img {
            width: 50px; /* Adjust size */
            height: 50px; /* Adjust size */
        }
    </style>
</head>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Task Management</span> </a>
                <div class="nav_list">
                    <a href="#" class="nav_link"> <i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Dashboard</span></a>
                    <a href="/tasks" class="nav_link active"> <i class='bx bx-task nav_icon'></i> <span class="nav_name">Tasks</span></a>
                    <a href="/categories" class="nav_link"> <i class='bx bx-category nav_icon'></i> <span class="nav_name">Categories</span></a>
                    <a href="/users" class="nav_link"> <i class='bx bx-user-plus nav_icon'></i> <span class="nav_name">Users</span></a>
<!--                    <a href="#" class="nav_link"> <i class='bx bx-user nav_icon'></i> <span class="nav_name">Users</span> </a>-->
<!--                    <a href="#" class="nav_link"> <i class='bx bx-message-square-detail nav_icon'></i> <span class="nav_name">Messages</span> </a>-->
<!--                    <a href="#" class="nav_link"> <i class='bx bx-bookmark nav_icon'></i> <span class="nav_name">Bookmark</span> </a>-->
<!--                    <a href="#" class="nav_link"> <i class='bx bx-folder nav_icon'></i> <span class="nav_name">Files</span> </a>-->
<!--                    <a href="#" class="nav_link"> <i class='bx bx-bar-chart-alt-2 nav_icon'></i> <span class="nav_name">Stats</span> </a>-->
                </div>
            </div>
            <a href="#" class="nav_link"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">SignOut</span> </a>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="content" id="content">-
        <?= $this->renderSection('content') ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div id="toastContainer" class="toast-container"></div>
        </div>
    </div>
    <!-- Loader Element -->
    <div id="loader" style="display: none;">
        <img src="loader.gif" alt="Loading..."> <!-- Replace with your loader image or spinner -->
    </div>
<!--Container Main end-->

<!--<div class="sidebar" id="sidebar">-->
<!--    <div class="sidebar-header">Menu</div>-->
<!--    <a href="/tasks">Task Listing</a>-->
<!--    <a href="/categories">Category Listing</a>-->
<!--    <button class="collapse-btn" id="collapse-btn">Collapse</button>-->
<!--</div>-->
<!---->
<!--<div class="content" id="content">-->
<!--    --><?php //= $this->renderSection('content') ?>
<!--</div>-->

<!-- Bootstrap JS, Popper.js, and jQuery -->
<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>-->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
<script>
    $(document).ready(function() {
        // Show loader before AJAX request starts
        $(document).ajaxStart(function() {
            $('#loader').show();
        });

        // Hide loader after AJAX request completes
        $(document).ajaxStop(function() {
            $('#loader').hide();
        });
    });
    document.addEventListener("DOMContentLoaded", function(event) {

        const showNavbar = (toggleId, navId, bodyId, headerId) =>{
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId)

            // Validate that all variables exist
            if(toggle && nav && bodypd && headerpd){
                toggle.addEventListener('click', ()=>{
                    // show navbar
                    nav.classList.toggle('show')
                    // change icon
                    toggle.classList.toggle('bx-x')
                    // add padding to body
                    bodypd.classList.toggle('body-pd')
                    // add padding to header
                    headerpd.classList.toggle('body-pd')
                })
            }
        }

        showNavbar('header-toggle','nav-bar','body-pd','header')

        /*===== LINK ACTIVE =====*/
        const linkColor = document.querySelectorAll('.nav_link')

        function colorLink(){
            if(linkColor){
                linkColor.forEach(l=> l.classList.remove('active'))
                this.classList.add('active')
            }
        }
        linkColor.forEach(l=> l.addEventListener('click', colorLink))

        // Your code to run since DOM is loaded and ready
    });
</script>

</body>
</html>
