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
          // document.write(UserName[0]["User_Name"] +', '+ UserName[0]["Group_Name"]);
          document.write(UserName[0]["User_Name"]);     
      });
      
      
  }
</script>

  {{-- Bootstrap TreeView --}}
<script type="text/javascript">
  // jquery ready start
  $(document).ready(function() {
    // jQuery code
  
    //////////////////////// Prevent closing from click inside dropdown
      $(document).on('click', '.dropdown-menu', function (e) {
        e.stopPropagation();
      });
  
      // make it as accordion for smaller screens
      if ($(window).width() < 992) {
        $('.dropdown-menu a').click(function(e){
          e.preventDefault();
            if($(this).next('.submenu').length){
              $(this).next('.submenu').toggle();
            }
            $('.dropdown').on('hide.bs.dropdown', function () {
              $(this).find('.submenu').hide();
            })
        });
        
        $('.dropdown-item').click( function(e) {
            e.preventDefault();
            window.location.href = $(this).attr('href');
        })
      }
    
     
  }); // jquery end

  
  </script>

<style type="text/css">
	@media (min-width: 992px){
		.dropdown-menu .dropdown-toggle:after{
      border-top: .3em solid transparent;
      border-right: 0;
      border-bottom: .3em solid transparent;
      border-left: .3em solid;
		}

		.dropdown-menu .dropdown-menu{
			margin-left:0; margin-right: 0;
		}

		.dropdown-menu li{
			position: relative;
		}
		.nav-item .submenu{ 
			display: none;
			position: absolute;
			left:100%; top:-7px;
		}
		.nav-item .submenu-left{ 
			right:100%; left:auto;
		}

		.dropdown-menu > li:hover{ background-color: #f1f1f1 }
		.dropdown-menu > li:hover > .submenu{
			display: block;
		}
	}
</style>

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
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPortfolio" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            SamplingRecords
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownPortfolio"> 
            <li><a class="dropdown-item" href="SamplingRecord">SamplingRecords</a></li>  
            <li><a class="dropdown-item" href="ProductSPEC">ProductSPEC</a></li>   
            <li><a class="dropdown-item" href="AbnormalEvent">AbnormalEvent</a></li>
            <li><a class="dropdown-item" href="MyCharts">MyFavoriteChart</a></li>       
          </ul>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">  
            Production  
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item dropdown-toggle" href="#"> PDMAT </a>
                <ul class="submenu dropdown-menu">
                  <li><a class="dropdown-item" href="SolventRemoval">SolventRemoval</a></li>
                  <li><a class="dropdown-item" href="Sublimation">Sublimation</a></li>
                  <li><a class="dropdown-item" href="GrindingOven">Grinding&Oven</a></li>
                </ul>
            </li>
            <li><a class="dropdown-item dropdown-toggle" href="#">Container </a>
                <ul class="submenu dropdown-menu">
                  <li><a class="dropdown-item" href="Container_GdSp">GoldenSample</a></li>
                  <li><a class="dropdown-item" href="ContainerRecord">Container Record</a></li>
                  <li><a class="dropdown-item" href="ContainerSPEC">Container SPEC</a></li>
                </ul>
            </li>
            <li><a class="dropdown-item dropdown-toggle" href="#">Balance </a>
                <ul class="submenu dropdown-menu">
                  <li><a class="dropdown-item" href="ContainerBalance">鋼瓶重量紀錄</a></li>
                </ul>
            </li>
          </ul>
        </li>
  
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Authority
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <li><a class="dropdown-item" href="Authority">SamplingRecordsAuthority</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownBlog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Training Material
          </a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownBlog">
            <li><a class="dropdown-item" href="ShowVideo">SamplingRecordsCharts</a></li>       
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>