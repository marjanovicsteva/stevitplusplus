<?php
    $cppfile = fopen("main.cpp", "w");
    $cppargv = fopen("argv.txt", "w");
    $errored = fopen("error.log", "w");
    if (isset($_POST["code"])) {
      $code = $_POST["code"];
    } else {
      $code = 
'
#include <iostream>

using namespace std;

int main() {
  cout << "Hello, World!";
  return 0;
}
';
    }
    $args = $_POST["arguments"];
    fwrite($cppfile, $code);
    fwrite($cppargv, $args);

    exec("g++ -std=c++11 main.cpp 2> error.log");
    if (filesize("error.log") > 0) {
        $output = file_get_contents("error.log");
        $output = "<strong>There was an error while compiling your code</strong><br>" . $output;
    }
    else {
        $output = exec("./a.out < argv.txt");
        $output = "<strong>Output</strong><br>" . $output;
    }
?>

<html>
  <head>
    <meta charset="UTF-8" />
    <title>Stevit++</title>
    <link rel="icon" href="http://www.stevit.rs/images/coffee.png" />
    
    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

    <!-- BootsrapCSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- BootstrapJS CDN -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
    <!-- CodeMirror + Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/codemirror.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/theme/dracula.min.css" type="text/css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/codemirror.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/mode/clike/clike.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/addon/selection/active-line.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/addon/edit/matchbrackets.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.36.0/addon/edit/closebrackets.min.js"></script>

    <style type="text/css">
      .navbar-brand {
        font-family: "Satisfy", serif;
        font-size: 140%;
      }
  
      body {
        background-color: #343a40 !important;
        font-family: monospace;
      }

      input[name=arguments]::-webkit-input-placeholder {
        font-family: monospace;
      }
      
      h1 {
        color: white;
      }
      
      textarea[name=code] {
        width: 100%;
      }
      
      input[name=arguments] {
        background-color: #282a36;
        border: none;
        color: white;
      }
      
      .lower > input[type=text] {
        float: left;
      }
      
      .lower > button[type=submit] {
        float: right;
      }
      
      .clear {
        clear: both;
      }
      
      p {
        color: white;
      }
      
      .navbar-text {
        font-family: monospace;
      }
      
      .center-div {
        padding-top: 30px;
      }

      .output {
        word-wrap: break-word;
      }

      .row {
        margin-right: 0;
      }

      .center-div {
        text-align: center;
      }

      .left-div {
        display: inline-block;
        text-align: left;
        max-width: 80%;
      }
    </style>
  </head>
    
  <body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-dark bg-dark justify-content-between">
      <a class="navbar-brand" href="#">
        <img src="https://i.imgur.com/03OOe0H.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Stevit++
      </a>
      <span class="navbar-text">
        Stevit C++ IDE
      </span>
    </nav>
    
    <form method="POST">
      <div class="row">
        <div class="col-6">
          <textarea id="code" name="code"><?php echo $code; ?></textarea>
        </div>
        
        <div class="col-6">
          <div class="center-div">
            <div class="left-div">
              <pre class="text-white output"><?php echo $output; ?></pre>
            </div>
          </div>
        </div>
      </div>
      <br />
      <div class="lower container">
        <input placeholder=" Argumenti" type="text" name="arguments" />
        <button class="btn btn-outline-success" type="submit">Build <i class="fas fa-play"></i></button>
      </div>
      <div class="clear"></div>
    </form>
    
    <script>
      /* global CodeMirror */
      var code = document.getElementById("code");
      var editor = CodeMirror.fromTextArea(code, {
          mode: "text/x-c++src",
          theme: "dracula",
          indentUnit: 2,
          autoCloseBrackets: true,
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true
      });
      editor.setSize(null, "70%");
    </script>
  </body>
</html>