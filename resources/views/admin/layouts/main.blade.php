<!--

=========================================================
* Argon Dashboard 2 Tailwind - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="./assets/img/favicon.png" />
    <title>{{ $title }}</title>
    @include('admin.layouts.link')

    <style type="text/css">
    .ck-editor__editable_inline
    {
      height: 350px;
    }

    .ck.ck-content ul,
    .ck.ck-content ul li {
      list-style-type: inherit;
    }

    .ck.ck-content ul {
      /* Default user agent stylesheet, you can change it to your needs. */
      padding-left: 40px;
    }

    .ck.ck-content ol,
    .ck.ck-content ol li {
      list-style-type: decimal;
    }
    .ck.ck-content ol {
      /* Default user agent stylesheet, you can change it to your needs. */
      padding-left: 40px;
    }

    .ck-content .image {
      /* Block images */
      max-width: 50%;
      margin: 20px auto;
    }
    </style>

  </head>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 min-h-75"></div>
    @include('admin.layouts.header')

        @yield('content')

      </main>
  </body>
  @include('admin.layouts.script')
</html>
