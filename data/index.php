<?php
?>
<!doctype html>
<html>
    <head>
        <title>LEDControl</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
              integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
              crossorigin="anonymous">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css"
              integrity="sha512-3q8fi8M0VS+X/3n64Ndpp6Bit7oXSiyCnzmlx6IDBLGlY5euFySyJ46RUlqIVs0DPCGOypqP8IRk/EyPvU28mQ=="
              crossorigin="anonymous"/>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css"/> <!-- 'monolith' theme -->

        <style>
            #RGB {
                height: 10vh;
                background: rgb(128, 128, 128);
            }

            #RC .slider-selection {
                background: #FF8282;
            }

            #RC .slider-handle {
                background: red;
            }

            #GC .slider-selection {
                background: #428041;
            }

            #GC .slider-handle {
                background: green;
            }

            #BC .slider-selection {
                background: #8283FF;
            }

            #BC .slider-handle {
                border-bottom-color: blue;
            }

            #R, #G, #B {
                width: 300px;
            }

            #existingColors a {
                margin-top: 10px;
            }
        </style>
    </head>

    <body>

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#">LEDControl</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <br><br><br>

        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Direct RGB Control</h5>


                            <p>
                                <b>R&nbsp;&nbsp;</b> <input type="text" class="span2" value="" data-slider-min="0"
                                                            data-slider-max="255" data-slider-step="1"
                                                            data-slider-value="0" data-slider-id="RC" id="R"
                                                            data-slider-tooltip="hide" data-slider-handle="square"/>
                            </p>
                            <p>
                                <b>G&nbsp;&nbsp;</b> <input type="text" class="span2" value="" data-slider-min="0"
                                                            data-slider-max="255" data-slider-step="1"
                                                            data-slider-value="0" data-slider-id="GC" id="G"
                                                            data-slider-tooltip="hide" data-slider-handle="round"/>
                            </p>
                            <p>
                                <b>B&nbsp;&nbsp;</b> <input type="text" class="span2" value="" data-slider-min="0"
                                                            data-slider-max="255" data-slider-step="1"
                                                            data-slider-value="0" data-slider-id="BC" id="B"
                                                            data-slider-tooltip="hide" data-slider-handle="triangle"/>
                            </p>
                            <div id="RGB"></div>

                            <hr>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Save Color</label>
                                <input onkeyup="updateSaveInput()" type="text" class="form-control" id="cName"
                                       aria-describedby="cNameH">
                                <small id="cNameH" class="form-text text-muted">Enter the name of the color.</small>
                            </div>
                            <button id="saveColorButton" type="submit" class="btn btn-secondary">Save Color</button>


                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Existing colors</h5>

                            <div id="existingColors">

                            </div>

                        </div>
                    </div>
                    <br>

                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Color Picker</h5>


                            <div id="cpicker" class="color-picker"></div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
                integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
                integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"
                integrity="sha512-f0VlzJbcEB6KiW8ZVtL+5HWPDyW1+nJEjguZ5IVnSQkvZbwBt2RfCBY0CBO1PsMAqxxrG4Di6TfsCPP3ZRwKpA=="
                crossorigin="anonymous"></script>
        <script>
        <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>

        <script>


            var colors = [];


            var RGBChange = function () {
                $('#RGB').css('background', 'rgb(' + r.getValue() + ',' + g.getValue() + ',' + b.getValue() + ')')
            };

            var r = $('#R').slider()
                .on('slide', RGBChange)
                .data('slider');
            var g = $('#G').slider()
                .on('slide', RGBChange)
                .data('slider');
            var b = $('#B').slider()
                .on('slide', RGBChange)
                .data('slider');


            function updateSaveInput() {
                if (document.getElementById("cName").value !== "") {
                    document.getElementById("saveColorButton").classList.remove("btn-secondary");
                    document.getElementById("saveColorButton").classList.add("btn-success");
                } else {
                    document.getElementById("saveColorButton").classList.add("btn-secondary");
                    document.getElementById("saveColorButton").classList.remove("btn-success");
                }
            }



            function readColors() {
                $.getJSON('colors.json', function (json) {
                    for (var key in json) {
                        if (json.hasOwnProperty(key)) {
                            var item = json[key];
                            colors.push({
                                name: item.name,
                                rgb: item.rgb
                            });


                            document.getElementById("existingColors").innerHTML += "<a href=\"/getColor?name=" + item.name + "\" class=\"btn btn-secondary\" style=\"background-color: #" + item.rgb + "\">" + item.name + "</a>&nbsp;";

                        }
                    }

                    console.log(colors)
                });
            }



            $( document ).ready(function() {
                console.log("ready");
                readColors();
            });


            // Simple example, see optional options for more configuration.
            const pickr = Pickr.create({
                el: '.color-picker',
                theme: 'monolith', // or 'monolith', or 'nano'



                swatches: [
                    'rgba(244, 67, 54, 1)',
                    'rgba(233, 30, 99, 0.95)',
                    'rgba(156, 39, 176, 0.9)',
                    'rgba(103, 58, 183, 0.85)',
                    'rgba(63, 81, 181, 0.8)',
                    'rgba(33, 150, 243, 0.75)',
                    'rgba(3, 169, 244, 0.7)',
                    'rgba(0, 188, 212, 0.7)',
                    'rgba(0, 150, 136, 0.75)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(139, 195, 74, 0.85)',
                    'rgba(205, 220, 57, 0.9)',
                    'rgba(255, 235, 59, 0.95)',
                    'rgba(255, 193, 7, 1)'
                ],

                components: {

                    // Main components
                    preview: true,
                    opacity: true,
                    hue: true,

                    // Input / output Options
                    interaction: {
                        hex: true,
                        rgba: true,
                        hsla: true,
                        hsva: true,
                        cmyk: true,
                        input: true,
                        clear: true,
                        save: true
                    }
                }
            });

        </script>
    </body>
</html>
