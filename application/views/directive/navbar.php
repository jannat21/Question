
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

                <li ng-class="{active:currentState.match('^school')}">
                    <a ui-sref="school"><i class="fa fa-book"></i> مدارس</a>
                </li>

                <li ng-class="{active:currentState.match('^payeCource')}">
                    <a ui-sref="payeCource"><i class="fa fa-book"></i> دروس</a>
                </li>

                <li class="dropdown" ng-class="{active:currentState.match('^examination'),active:currentState.match('^examinationList')}">
                    <a class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">آزمون<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li ng-class="{active:currentState.match('^examination')}">
                            <a ui-sref="examination">ایجاد آزمون</a>
                        </li>
                        <li ng-class="{active:currentState.match('^examinationList')}">
                            <a ui-sref="examinationList">لیست آزمون ها</a>
                        </li>
                    </ul>
                </li>

                <li class="pull-left"><a href="<?= site_url(); ?>/Login/logout"><i class="fa fa-power-off"></i>&nbsp; خروج</a>
                </li>

            </ul>
        </div>
    </div>
</div>
