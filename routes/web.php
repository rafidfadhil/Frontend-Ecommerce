<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\SupplierProductController;
use App\Http\Controllers\SupplierOrderController;
use App\Http\Controllers\SupplierMemberController;
use App\Http\Controllers\SupplierCourseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierChatController;
use App\Http\Controllers\SupplierForumController;
use App\Http\Controllers\SupplierArtikelController;

use App\Http\Controllers\ResellerTokoController;
use App\Http\Controllers\ResellerOrderController;
use App\Http\Controllers\ResellerMemberController;
use App\Http\Controllers\ResellerCourseController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\ResellerChatController;
use App\Http\Controllers\ResellerForumController;
use App\Http\Controllers\ResellerCartController;
use App\Http\Controllers\ResellerArtikelController;

use App\Http\Controllers\AdminTopicController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminProductCategoryController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminLessonController;
use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AdminChartController;
use App\Http\Controllers\AdminArticleController;

Route::get("/", [HomeController::class, "index"])->middleware(["auth", "verified",]);
Route::get("/dashboard", [HomeController::class, "index"])->middleware(["auth", "verified"])->name("dashboard");

Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");
});

Route::get("/admin", [HomeController::class, "index"])->middleware(["auth", "admin",]);
Route::get("/admin/product-categories/checkSlug", [AdminProductCategoryController::class, "checkSlug",])->middleware(["auth", "admin"]);
Route::get("/admin/topics/checkSlug", [AdminTopicController::class, "checkSlug",])->middleware(["auth", "admin"]);
Route::get("/admin/articles/checkSlug", [AdminArticleController::class, "checkSlug",])->middleware(["auth", "admin"]);
Route::resource("/admin/product-categories", AdminProductCategoryController::class)->middleware(["auth", "admin"]);
Route::resource("/admin/topics", AdminTopicController::class)->middleware(["auth", "admin",]);
Route::resource("/admin/users", UserController::class)->middleware(["auth", "admin",]);
Route::resource("/admin/articles", AdminArticleController::class)->middleware(["auth", "admin",]);
Route::resource("/admin/courses", AdminCourseController::class)->middleware(["auth", "admin",]);
Route::resource("/admin/lessons", AdminLessonController::class)->middleware(["auth", "admin",]);
Route::get("/admin/products", [AdminProductController::class, "index",])->middleware(["auth", "admin"]);
Route::post("/upload", [HomeController::class, "upload"])->name("ckeditor.upload");
Route::get("/admin/orders", [AdminOrderController::class, "index"])->middleware(["auth", "admin"]);
Route::get("/admin/orders/{order_number}/show", [AdminOrderController::class, "show",])->middleware(["auth", "admin"]);
Route::post("/admin/orders/{order_number}/approve", [AdminOrderController::class, "approvePayment",])->middleware(["auth", "admin"]);
Route::post("/admin/orders/{order_number}/reject", [AdminOrderController::class, "rejectPayment",])->middleware(["auth", "admin"]);
Route::get("/admin/orders/{order_number}/payment", [AdminOrderController::class, "paymentPage",])->middleware(["auth", "admin"]);
Route::post("/admin/orders/{order_number}/upload-proof", [AdminOrderController::class, "transferPayment",])->middleware(["auth", "admin"]);
Route::post("/admin/users/{user}/suspend", [UserController::class, "suspendUser",])->middleware(["auth", "admin"]);
Route::post("/admin/users/{user}/unsuspend", [UserController::class, "unsuspendUser",])->middleware(["auth", "admin"]);
Route::get("/api/chart-data", [AdminChartController::class, "index",])->middleware(["auth", "admin"]);

// Supplier Route
Route::middleware(["auth", "supplier"])->group(function () {

    // Supplier Dashboard and Profile
    Route::get("/supplier", [SupplierController::class, "index"])->name("supplier.index");
    Route::get("/supplier/{id}/edit", [SupplierController::class, "edit",])->name("supplier.edit");
    Route::put("/supplier/{id}", [SupplierController::class, "update"])->name("supplier.update");

    // Product
    Route::get("/supplier/product", [SupplierProductController::class, "index",])->name("supplier.product.index");
    Route::post("/supplier/product", [SupplierProductController::class, "store",])->name("supplier.product.store");
    Route::put("/supplier/product/{id}", [SupplierProductController::class, "update",])->name("supplier.product.update");
    Route::delete("/supplier/product/{id}", [SupplierProductController::class, "destroy",])->name("supplier.product.destroy");
    Route::get("/supplier/stock", [SupplierProductController::class, "stock",])->name("supplier.product.stock");

    // Order
    Route::get("/supplier/order", [SupplierOrderController::class, "index",])->name("supplier.order.index");
    Route::put("/supplier/order/{id}", [SupplierOrderController::class, "update",])->name("supplier.order.update");
    Route::get("/supplier/history", [SupplierOrderController::class, "history",])->name("supplier.order.history");

    // Member
    Route::get("/supplier/member", [SupplierMemberController::class, "index",])->name("supplier.member.index");
    Route::get("/supplier/member/list", [SupplierMemberController::class, "list",])->name("supplier.member.list");
    Route::post("/supplier/product/member", [SupplierMemberController::class, "store",])->name("supplier.product.member.store");
    Route::put("/supplier/product/member/{id}", [SupplierMemberController::class, "update",])->name("supplier.product.member.update");
    Route::delete("/supplier/product/member/{id}", [SupplierMemberController::class, "destroy",])->name("supplier.product.member.destroy");

    // Notif
    Route::get("/supplier/notif", [SupplierController::class, "notif",])->name("supplier.notif.index");

    // Chat
    Route::get("/supplier/chat", [SupplierChatController::class, "index",])->name("supplier.chat.index");

    // Forum Member
    Route::get("/supplier/forum", [SupplierForumController::class, "index",])->name("supplier.forum.index");
    Route::post("/supplier/forum/store", [SupplierForumController::class, "store",])->name("supplier.forum.store");

    // Artikel
    Route::get("/supplier/artikel", [SupplierArtikelController::class, "index",])->name("supplier.artikel.index");

    // Course
    Route::get("/supplier/course", [SupplierCourseController::class, "index",])->name("supplier.course.index");
    Route::get("/supplier/lesson/{id}", [SupplierCourseController::class, "lesson",])->name("supplier.course.lesson");
});

// Reseller Route
Route::middleware(["auth", "reseller"])->group(function () {

    // Reseller Dashboard and Profile
    Route::get("/reseller", [ResellerController::class, "index"])->name("reseller.index");
    Route::get("/reseller/{id}/edit", [ResellerController::class, "edit",])->name("reseller.edit");
    Route::put("/reseller/{id}", [ResellerController::class, "update"])->name("reseller.update");

    // Product
    Route::get("/reseller/product/{id}/show", [ResellerController::class, "show",])->name("reseller.product.show");
    Route::get("/reseller/product/compare", [ResellerController::class, "compare",])->name("reseller.product.compare.empty");
    Route::get("/reseller/product/compare/{id1}/{id2}", [ResellerController::class, "compare",])->name("reseller.product.compare");
    Route::get("/reseller/search", [ResellerController::class, "search"])->name("reseller.product.search");
    Route::get("/reseller/search2", [ResellerController::class, "search2",])->name("reseller.product.search2");

    // Cart
    Route::get("/reseller/cart", [ResellerCartController::class, "index",])->name("reseller.cart");
    Route::get("/reseller/cart/{productId}", [ResellerCartController::class, "store",])->name("reseller.cart.store");
    Route::put("/reseller/cart/{cartId}/update", [ResellerCartController::class, "update",])->name("reseller.cart.update");
    Route::post("/reseller/cart/{cartId}/destroy", [ResellerCartController::class, "destroy",])->name("reseller.cart.destroy");
    Route::post("/reseller/cart/order", [ResellerCartController::class, "order",])->name("reseller.cart.order");
    Route::post("/reseller/cart/ordernow", [ResellerCartController::class, "order_now",])->name("reseller.cart.ordernow");
    Route::get("/reseller/cart_order/{time}", [ResellerCartController::class, "order_show",])->name("reseller.cart.order.show");
    Route::get("/reseller/cart_order/payment/{time}", [ResellerCartController::class, "order_payment",])->name("reseller.cart.order.payment");

    // Order
    Route::get("/reseller/order", [ResellerOrderController::class, "index",])->name("reseller.order.index");
    Route::post("/reseller/order/cancel", [ResellerOrderController::class, "cancel",])->name("reseller.order.cancel");
    Route::put("/reseller/order/store", [ResellerOrderController::class, "store",])->name("reseller.order.store");
    Route::get("/reseller/order/{order_number}/show", [ResellerOrderController::class, "show",])->name("reseller.order.show");
    Route::post("/reseller/order/{id}/update", [ResellerOrderController::class, "update",])->name("reseller.order.update");

    // Toko
    Route::get("/reseller/toko/{supplier_name}", [ResellerTokoController::class, "index",])->name("reseller.toko.index");
    Route::get("/reseller/toko/member/{supplier_id}", [ResellerTokoController::class, "member",])->name("reseller.toko.member");

    // Chat
    Route::get("/reseller/chat", [ResellerChatController::class, "index",])->name("reseller.chat.index");

    // Forum Member
    Route::get("/reseller/forum", [ResellerForumController::class, "index",])->name("reseller.forum.index");
    Route::get("/reseller/forum/{supplier_id}", [ResellerForumController::class, "show",])->name("reseller.forum.show");
    Route::post("/reseller/forum/store", [ResellerForumController::class, "store",])->name("reseller.forum.store");

    // Member
    Route::get("/reseller/member", [ResellerMemberController::class, "index",])->name("reseller.member.index");

    // Notif
    Route::get("/reseller/notif", [ResellerController::class, "notif",])->name("reseller.notif.index");

    // Artikel
    Route::get("/reseller/artikel", [ResellerArtikelController::class, "index",])->name("reseller.artikel.index");

    // Course
    Route::get("/reseller/course", [ResellerCourseController::class, "index",])->name("reseller.course.index");
    Route::get("/reseller/lesson/{id}", [ResellerCourseController::class, "lesson",])->name("reseller.course.lesson");
});

Route::fallback(function () {
    return view("pages-error404");
});

require __DIR__ . "/auth.php";
