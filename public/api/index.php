<?php

    // help page

?>


<script>

    // 'use strict';
    let request = new XMLHttpRequest();
    request.onload = (event) => {
        console.log('Resonse loaded');
    }
    request.open(
        'GET',
        'https://dev.requestx.ch/api/test'
    );
    request.setRequestHeader('Accept', 'application/json');
    request.setRequestHeader('Access-Control-Allow-Origin', '*');
    request.send();

</script>
