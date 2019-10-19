<?php

    function responseBadRequest() {
        http_response_code(400);
        echo json_encode([
            "releaseNo" => REQX_RELEASENO,
            "error_type" => "Invalid parameter"
        ]);
    }

    function responseOk() {
        http_response_code(200);
        echo json_encode([
            "releaseNo" => REQX_RELEASENO,
            "error_type" => "(none)"
        ]);
    }

