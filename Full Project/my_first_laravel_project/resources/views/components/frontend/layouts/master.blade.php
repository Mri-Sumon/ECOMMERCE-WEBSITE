<!DOCTYPE html>
<html>

<x-frontend.layouts.partials.css/>

<body>
    <div class="hero_area">
        {{$slot}}
        <x-frontend.layouts.partials.footer/>
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>
    <x-frontend.layouts.partials.js/>
</body>

</html>
