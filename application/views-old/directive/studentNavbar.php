
<div class="navbar navbar-inverse navbar-static-top" style="width: 100%;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" style="float: right;">
            <ul class="nav navbar-nav navbar-right">
                <!--<li ng-class="{active:currentState.match('^test2')}">
                    <a ui-sref="test2">test2</a>
                </li>-->
                
                <li ng-class="{active:currentState.match('^examination')}">
                    <a ui-sref="examination"><i class="fa fa-pencil"></i> xxx</a>
                </li>
                <li ng-class="{active:currentState.match('^payeCource')}">
                    <a ui-sref="payeCource"><i class="fa fa-book"></i> yyy</a>
                </li>
                
                
                <li class="pull-left"><a href="<?= site_url();?>/Login/logout"><i class="fa fa-power-off"></i>&nbsp; خروج</a>
                </li>
                
            </ul>
        </div>
    </div>
</div>
