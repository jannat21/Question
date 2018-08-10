<div class="main-menu">
    <ul>
        <!--<li ng-class="{active:currentState.match('^test2')}">
            <a ui-sref="test2"><i class="fa fa-2x fa-list-ol"></i><span class="nav-text">&nbsp;TEST2</span></a>
        </li>-->
    </ul>

    <ul class="logout">
        <li>
            <a href="<?= site_url('/login/login/logout'); ?>">
                <i class="fa fa-power-off fa-2x fa-icon"></i><span class="nav-text">خروج</span>
            </a></li>
    </ul>
</div>


<style>
    .li-dropdown{padding: 7px; }
    .fa-icon{position: relative;display: table-cell;width: 60px;height: 36px;text-align: center;vertical-align: middle;font-size: 20px;}
    .main-menu:hover,nav.main-menu.expanded{width: 250px; overflow: visible;}
    .main-menu{background: #fbfbfb; border-right: 1px solid #e5e5e5; position: absolute; top: 0; bottom: 0; height: 100%; right: 0;
               width: 60px; overflow: hidden; -webkit-transition: 0.5s linear; transition: 0.5s linear; -webkit-transform: translateZ(0)scale(1,1); z-index:1000;}
    .main-menu>ul{margin: 7px 0;}
    .main-menu li{position: relative; display: block; width: 250px;}
    .main-menu li>a{position: relative;display: table; border-collapse: collapse; border-spacing: 0; color: #999; font-size: 14px;
                    text-decoration: none; -webkit-transform: translateZ(0)scale(1,1);-webkit-transition: all 0.1s linear; transition: all .1s linear;}
    .main-menu .nav-icon{position: relative; display: table-cell; width: 60px; height: 36px; text-align: center;vertical-align: middle;font-size: 18px;}
    .main-menu .nav-text{position: relative; display: table-cell; width: 190px; vertical-align: middle;}
    .main-menu>ul.logout{position: absolute;right: 0;bottom: 0;}
    a:hover,a:focus{text-decoration: none;}
    nav{-webkit-user-select: none; -moz-user-select:none; -ms-user-select:none; -o-user-select:none; user-select:none;}
    nav ul,nav li{outline: 0;margin: 0;padding: 0}
    .main-menu li:hover>a,nav.main-menu li.active>a,.dropdown-menu>li>a:hover,.dropdown-menu>li>a:focus,.dropdown-menu>.active>a,.dropdown-menu>.active>a:hover,.dropdown-menu>.active>a:focus,.no-touch .dashboard-page nav.dashboard-menu ul li:hover a, .dashboard-page nav.dashboard-menu ul li.active a{color: #FFF;background-color: #5fa2db;}
</style>