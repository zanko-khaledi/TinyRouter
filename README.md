TinyRouter

For use this module to you'r php pure project's you should first 
download the release and execute Router instance on "index.php" root project.
PHP Version 8.1

for download script via git :

     $ mkdir project-name && cd  project-name
     $ git clone https://github.com/zanko-khaledi/TinyRouter.git

usnig router inside the script.
eg:
 
index.php 

    <?php
    
    use \App\Router;
    use \App\Http\Request;
    use \App\Http\Response;

    require_once __DIR__."/TinyRouter/src/Router.php";

    try{

        Router::execute();

        Router::get("/bar",function(Request $request,Response $response){
        
           echo $response->json('Hello World',200);
           
         });

        /* 
        * for collections
        */

        Router::collection("/home",function(){
        
           Router::get("/blog",[BlogController::class,"list"]);
           
           Router::post("/blog/create",[BlogController::class,"create"]);
           
         });

       /*
        * other route methods(post,put,patch,delete)
        */

     } catch(Exception | BadMethodCallException $e){
     
         echo $e->getMessage();
         
     }
