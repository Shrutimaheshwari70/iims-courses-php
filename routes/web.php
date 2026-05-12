<?php
/**
 * routes/web.php
 * Route mapping — equivalent to src/router.tsx + src/routeTree.gen.ts
 */
return [
    '/'           => 'index.php',
    '/about'      => 'pages/about.php',
    '/blogs'      => 'pages/blogs.php',
    '/careers'    => 'pages/careers.php',
    '/colleges'   => 'pages/colleges.php',
    '/compare'    => 'pages/compare.php',
    '/contact'    => 'pages/contact.php',
    '/courses'    => 'pages/courses.php',
    '/wishlist'   => 'pages/wishlist.php',
    '/blogs/:slug'    => 'pages/blog-details.php',
    '/colleges/:slug' => 'pages/college-details.php',
    '/courses/:slug'  => 'pages/course-details.php',
];
