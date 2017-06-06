@extends ('admin.layouts.plane')
@section ('body')
<div class="container" style="padding-top: 100px;" ng-controller="LoginController">
    <div class="row">
        <br>
        <center><b>OnlineBio Admin Panel</b></center>
        <br>
        <p style="text-align: center;">&nbsp;<span style="color:#F00; font-size:11px;" ng-bind="lbl_error">&nbsp;</span></p>
    </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
               @section ('login_panel_title','Please Sign In Here')
               @section ('login_panel_body')
               <form role="form" ng-submit="submitForm();" name="frmLogin" id="frmLogin">
                    <fieldset>
                        <div class="form-group">
                            <input class="form-control" placeholder="E-mail" ng-model="login.email" ng-required="true"  type="email" autofocus >
                        </div>
                        <div class="form-group">
                            <input class="form-control" placeholder="Password" ng-model="login.password" ng-required="true" type="password" value="">
                        </div>
                        <div class="checkbox">
<!--                            <label>
                                <input name="remember" type="checkbox" value="Remember Me">Remember Me
                            </label>-->
                        </div>
                        <!-- Change this to a button or input when using this as a form -->
                        <button  type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                    </fieldset>
                </form>
                    
                @endsection
                @include('admin.widgets.panel', array('as'=>'login', 'header'=>true))
            </div>
        </div>
    </div>
<script type="text/javascript">
    app.controller('LoginController', function($scope, $sce, $http, $window, API_URL) {
        $scope.submitForm = function() { 
        var url = API_URL + "api/backend/postLogin";
        //console.log($scope.login);
        // Posting data to controller
        $http({
        method: 'POST',
        url: url,
        data: $.param($scope.login),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(response) { //alert(response);return false;
                console.log(response);
                if(response == "0"){
                        $scope.lbl_error = 'Wrong email or password you have entered !!!';
                        if($scope.frmLogin.$invalid) return false;
                }else{
                        $window.location.href = API_URL + 'backend/dashboard';
                }
        }).error(function(response) {
        $scope.lbl_error = 'Something wrong in submit';
        });
        };
});
</script>
@stop