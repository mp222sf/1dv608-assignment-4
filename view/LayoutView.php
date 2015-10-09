<?php
// Start sessions.
session_start();

class LayoutView {


  
  public function render($isLoggedIn, $loginView, $datetimeView, $qStrReg) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>

          <h1>Assignment 4</h1>
          ' . $this->renderRegisterNewUser($isLoggedIn, $qStrReg) . '
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $loginView . '
              
              ' . $datetimeView . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) 
  {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegisterNewUser($isLoggedIn, $qStrRegister) 
  {
    if (!$isLoggedIn)
    {
      if (isset($_GET[$qStrRegister]))
      {
        return '<a href="?">Back to login</a>';
      }
      else 
      {
        return '<a href="?' . $qStrRegister . '">Register a new user</a>';
      }
    }
  }
}
