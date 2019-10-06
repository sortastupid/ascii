<?php
$fonts = [];
$fontfiles = glob('fonts/*.flf');
foreach ($fontfiles as $fontfile) {
    $fonts[] = pathinfo($fontfile)['filename'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ASCII generator by sorta stupid</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css">
        body {
          background-color: white;
          height: 100vh;
          margin: 0;
          overflow: hidden;
          padding: 0;
          color: white;
          font: 1.3rem monospace;
          text-shadow: 0 0 5px #C8C8C8;
        }



        ::selection {
          background: #0080FF;
          text-shadow: none;
        }

        #top {
            color: #000;
            background-color: #00ff00;
            width: 100%;
            padding: 2px;
            margin-bottom: 20px;
        }

        #text {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #outputFigDisplay {

        }

            pre {
                display: inline-block;
                font-family: monospace;
                line-height: initial;
                padding: 10px;
                color: #000;
                margin: 0;
                font-size: 1.5vw;
            }

            @media (min-width: 1024px) {
				pre {
					font-size: 1vw;
				}
			}

        .blink {
            animation: blink-animation 1s steps(5, start) infinite;
            -webkit-animation: blink-animation 1s steps(5, start) infinite;
            width: 5px;
            background-color: #00ff00;
            height: 100%;
        }

            @keyframes blink-animation {
              to {
                visibility: hidden;
              }
            }
            @-webkit-keyframes blink-animation {
              to {
                visibility: hidden;
              }
            }

        #bottom {
            position: fixed;
            width: 100%;
            bottom: 0%;
            color: #000;
            font-size: 2em;
        }

            #bottom ul {
                list-style: none;
                padding: 0;
                margin: 0;
            }

                #bottom li {
                    cursor: pointer;
                    width: 23%;
                    float: left;
                }

                    #bottom li span {
                        display: inline-block;
                        color: #000;
                        background-color: #fff;
                        width: 30px;
                    }

    .noselect {
      -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
         -khtml-user-select: none; /* Konqueror HTML */
           -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                                      supported by Chrome and Opera */
    }

    .modal-dialog {
        position: relative;
        display: table; /* This is important */
        overflow-y: auto;
        overflow-x: auto;
        width: auto;
        min-width: 300px;
    }


    .flex {
      display: flex;
      justify-content: space-between;
      flex-flow: row wrap;
    }

    .inside-right {
      flex: 1;
    }

    </style>
</head>
<body>
    <div id="top">
        <span>ASCII text generator 5000</span>
    </div>

    <textarea id="text"></textarea>

    <div class="flex">
      <div class="inside inside-left"><div id="outputFigDisplay"></div></div>
      <div class="inside inside-right"><div class="blink"></div></div>
    </div>

    <div id="bottom">
        <ul>
            <li id="btn-left"><span>←</span> Previous Font</li>
            <li id="btn-copy">Copy Text</li>
            <li id="btn-save">Convert to Image</li>
            <li id="btn-right">Next Font <span>→</span></li>

    </div>

<!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/3.0.0/fetch.min.js" integrity="sha256-E1M+0f/hvoNVoV8K5RSn1gwe4EFwlvORnOrFzghX0wM=" crossorigin="anonymous"></script>
-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/jquery.detect_swipe.js"></script>
    <script type="text/javascript" src="js/figlet.js"></script>
    <script type="text/javascript" src="js/clipboard.min.js"></script>
    <script type="text/javascript" src="js/html2canvas.min.js"></script>

<script>
    (function($) {
        var fonts = <?php echo json_encode($fonts) ?>;

        if (window.location.protocol === 'file:') {
            alert('fetch APi does not support file: protocol.');
        }

        figlet.defaults({
            fontPath: 'fonts'
        });

        var text = localStorage.getItem('text') || "sorta stupid";
        var counter = parseInt(localStorage.getItem('counter') || 18);

        var update = function() {
            var fontName = fonts[counter];
            var inputText = text;

            localStorage.setItem('text', text);

            figlet(inputText, {
                font: fontName,
            }, function(err, text) {
                if (err) {
                    console.log('something went wrong...');
                    console.dir(err);
                    return;
                }
                $('#outputFigDisplay').html("<pre>" + text + "</pre>");
            });

            /*
                How to read the metadata for a font
            */
            /*
            figlet.metadata(fontName, function(err, options, headerComment) {
                if (err) {
                    console.log('something went wrong...');
                    console.dir(err);
                    return;
                }
                console.dir(options);
                console.log(headerComment);
            });
            */
        };

        var previousFont = function() {
            counter = (counter - 1 < 0) ? fonts.length : counter - 1;
            localStorage.setItem('counter', counter);
            //~ $('#font').val(counter);
            update();
        }

        var nextFont = function() {
            counter = counter + 1 > fonts.length ? counter = 0 : counter + 1;
            localStorage.setItem('counter', counter);
            //~ $('#font').val(counter);
            update();
        }

        $('#text').val(text);

        $('#text').on('blur', function() {
            $('#text').focus();
        });

        $(document).on('keydown click', function() {
            $('#text').focus();
        });

        // Disable arrow keys in (hidden) textarea
        $('#text').bind('keydown', function(e) {
            var key = event.keyCode || event.charCode;

            if (key === 37 /* LEFT */ || key === 39 /* RIGHT */) {
                e.preventDefault();
            }
        });

        // Monitor textarea
        $('#text').bind('keyup', function(e) {
            var key = event.keyCode || event.charCode;

            if (key === 37 /* LEFT */) {
                previousFont();
            }

            else if (key === 39 /* RIGHT */) {
                nextFont();
            }

            else {
                text = $(this).val();
                update();
            }
        });

        $('#btn-left').on('click', function() {
            previousFont();
        });

        $('#btn-right').on('click', function() {
            nextFont();
        });

        $(document).on('swipeleft', function() {
			previousFont();
		});

		$(document).on('swiperight', function() {
			nextFont();
		});

        var clipboard = new ClipboardJS('#btn-copy', {
            text: function(trigger) {
                update();
                console.log(trigger);
                return $("#outputFigDisplay > pre").text();
            }
        });

        $('#btn-copy').tooltip({
            title: 'Copied!',
            placement: 'bottom',
            trigger: 'manual',
        });

        clipboard.on('success', function(e) {
            $('#btn-copy').tooltip('show');
            e.clearSelection();
            setTimeout(function() {
                $('#btn-copy').tooltip('hide');
            }, 5000);
        });

         $('#btn-save').tooltip({
            title: 'Converted!<br>(right click to save as image)',
            placement: 'bottom',
            trigger: 'manual',
            html: true
        });

        $('#btn-save').on('click', function() {
            update();
            html2canvas(document.querySelector("#outputFigDisplay > pre"), {
                backgroundColor: 'transparent'
            }).then(canvas => {
                $('#btn-save').tooltip('show');

                $('#outputFigDisplay').html('');
                $('#outputFigDisplay').append('<img src="' + canvas.toDataURL() + '">');

                setTimeout(function() {
                    $('#btn-save').tooltip('hide');
                }, 5000);
            });
        });

        // Init

        update();
    })(jQuery);
</script>

</body>
</html>
