<style>
.navbar-custom {
  /* background-color: #4292ca; */
  background-color: #6fa7d1;
}
.navbar{
  margin: 0px;
}

</style>

<script type="text/javascript">
   
 function findUser(){    
      var User = "<?php echo $_SERVER['REMOTE_USER']; ?>";
      var UserName = []; 
      $.ajax({
          async:false,
          url: "SamplingRecord/GetUserName",//路徑
          type: "Get",
          data:
              {
                  "User": User,
              },
      }).done(function(data){
          UserName = data.success; 
          document.write(UserName[0]["User_Name"] +', '+ UserName[0]["Group_Name"]);     
      });
      
      
  }
 </script>

 <!-- Navigation -->
 {{-- fixed-top --}}
 <nav class="navbar navbar-expand-lg navbar-dark bg-info  ">
  <div class="container" >
    {{-- <a class="navbar-brand" href="/">Merck</a> --}}
    <a href="/">
      <img class = "navbar-brand" src="img/RichPurple.png"  >
    </a>
    <a class="nav-link">Hi, <?php echo $_SERVER['REMOTE_USER'] ?>( <script language="javascript">findUser(); </script> )</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive" >
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          {{-- <a class="nav-link" href="SamplingRecord">Sampling Records</a> --}}
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            SamplingRecords
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"> 
            <a class="dropdown-item" href="SamplingRecord">SamplingRecords</a>  
            <a class="dropdown-item" href="ProductSPEC">ProductSPEC</a>      
          </div>
        </li> 
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            PDMAT
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio">          
            <a class="dropdown-item" href="SolventRemoval">SolventRemoval</a>
            <a class="dropdown-item" href="Sublimation">Sublimation</a>
            <a class="dropdown-item" href="GrindingOven">Grinding&Oven</a>          
          </div>
        </li>
        {{-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Batch
          </a>      
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <a class="dropdown-item" href="blog-home-1.html">Batch 1</a>
            <a class="dropdown-item" href="blog-home-2.html">Batch 2</a>
            <a class="dropdown-item" href="blog-post.html">Batch 3</a>
          </div>
        </li> --}}
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Authority
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <a class="dropdown-item" href="Authority">SamplingRecordsAuthority</a>
           
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Training Material
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <a class="dropdown-item" href="ShowVideo">SamplingRecordsCharts</a>
           
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>