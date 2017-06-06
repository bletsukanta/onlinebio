var app = angular.module('OnlineBioApp', ['vcRecaptcha','socialLinks', 'angular-flexslider']).constant('API_URL', 'http://192.168.0.114/onlinebio/');
//http://online.bio/  

 app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
  });
app.controller('createBioCtrl', function ($scope, $http, API_URL) {
    $scope.show_social_login_container = true;
    $scope.showemail = true;
    $scope.showmobile = true;
    $scope.getDomains = function () {
        $http({
            method: "POST",
            url: API_URL + "getDomains",
            data: {"domain_category": $scope.domain_category}
        }).then(function (response) {
            //alert(JSON.stringify(response.data));
            $scope.domain_arr = response.data;
        }, function (response) {
            alert('Error occured' + response.data);
        });
    }
    //For showing subdomain name after category,domain_name,user_name field filledup
    $scope.showSudomainName = function () {
        if ($scope.user_name && $scope.domain_name["domain_name"]) {
            $scope.show_sudomain_name = 'http://' + $scope.user_name + '.' + $scope.domain_name["domain_name"] + '.bio';
            $scope.show_social_login_container = false;
            $scope.showmobile = true;
            $scope.showemail = true;
        } else {
            $scope.show_sudomain_name = '';
            $scope.show_social_login_container = true;
            $scope.showmobile = true;
            $scope.showemail = true;
        }
    }
    //For showing the email form after clicking the email button
    $scope.showEmailForm = function () {
        $scope.show_social_login_container = true;
        $scope.showmobile = true;
        $scope.showemail = false;
    }
    //For showing the mobile form after clicking the mobile button
    $scope.showMobileForm = function () {
        $scope.show_social_login_container = true;
        $scope.showemail = true;
        $scope.showmobile = false;
    }
    //For closing the email and mobile form after clicking the cancel button
    $scope.closeForm = function () {
        $scope.showemail = true;
        $scope.showmobile = true;
        $scope.show_social_login_container = false;
    }
    $scope.createBioSubmit=function(){
        alert($scope.domain_category);
        console.log($scope.domain_category);
        if($scope.domain_category==null || $scope.domain_category==""){
            $scope.contact_err="Category is empty";
            alert($scope.contact_err);
            return;
        }else
            alert('else site');
    }
});
app.directive("mailcaptcha", function ($http, vcRecaptchaService) {
    return {
        restrict: "E",
        scope: {},
        //templateUrl:"contactForm.html",
        template: '<div vc-recaptcha theme="light" key="model.key" on-create="setWidgetId(widgetId)" on-success="setResponse(response)" on-expire="cbExpiration()"></div>',
        controller: function ($scope, $http, vcRecaptchaService) {
            //console.log("this is your app's controller");
            $scope.response = null;
            $scope.widgetId = null;
            $scope.model = {
                key: '6LfvTiQUAAAAALwvxtRGbcSK92cKY8zxP5Cc7gAp'
            };

            $scope.setResponse = function (response) {
                console.info('Response available');
                $scope.response = response;
            };

            $scope.setWidgetId = function (widgetId) {
                console.info('Created widget ID: %s', widgetId);
                $scope.widgetId = widgetId;
            };

            $scope.cbExpiration = function () {
                console.info('Captcha expired. Resetting response object');
                vcRecaptchaService.reload($scope.widgetId);
                $scope.response = null;
            };
            
        }
    };
});
app.directive("mobilecaptcha", function ($http, vcRecaptchaService) {
    return {
        restrict: "E",
        scope: {},
        //templateUrl:"contactForm.html",
        template: '<div vc-recaptcha theme="light" key="model.key" on-create="setWidgetId(widgetId)" on-success="setResponse(response)" on-expire="cbExpiration()"></div>',
        controller: function ($scope, $http, vcRecaptchaService) {
            //console.log("this is your app's controller");
            $scope.response = null;
            $scope.widgetId = null;
            $scope.model = {
                key: '6LfvTiQUAAAAALwvxtRGbcSK92cKY8zxP5Cc7gAp'
            };

            $scope.setResponse = function (response) {
                console.info('Response available');
                $scope.response = response;
            };

            $scope.setWidgetId = function (widgetId) {
                console.info('Created widget ID: %s', widgetId);
                $scope.widgetId = widgetId;
            };

            $scope.cbExpiration = function () {
                console.info('Captcha expired. Resetting response object');
                vcRecaptchaService.reload($scope.widgetId);
                $scope.response = null;
            };
        }
    };
});