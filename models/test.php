<?php
    // require_once './Post.php';

    // $test = new Post();
    // $test->updatePostN("1", "PT0012", "Trông 6 bé", "Cao Cấp", "15", "Trông trẻ ạ", "200000", "1100 KeangNam", "0123456789");
    // print("Done testing!");
    // Test oke

    // --------------------------------------------------------------------------------------------------------------------------

    require_once '../controllers/PostController.php';

    $test = new PostController();
    $test->update("1", "PT0012", "Trông 6 bé", "Cao Cấp", "15", "Trông trẻ ạ", "200000", "1100 KeangNam", "0123456789");
    print("Done testing!");
    // Test oke
?>