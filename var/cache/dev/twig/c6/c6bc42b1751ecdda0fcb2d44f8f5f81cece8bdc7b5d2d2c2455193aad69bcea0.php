<?php

/* :signin:form_login.html.twig */
class __TwigTemplate_744c98b898baa36cb814b67583759a072a6f27046400d64349f53f41428ae008 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("::layout.html.twig", ":signin:form_login.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":signin:form_login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <div class=\"container\">
        <div class=\"form-container\">

            ";
        // line 7
        if ((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 7, $this->source); })())) {
            // line 8
            echo "                <div class=\"error-container\">";
            echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\TranslationExtension']->trans(twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 8, $this->source); })()), "messageKey", array()), twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 8, $this->source); })()), "messageData", array()), "security"), "html", null, true);
            echo "</div>
            ";
        }
        // line 10
        echo "
            <div class=\"row\">
                <div class=\"col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4\">
                    <ul class=\"nav nav-tabs\" role=\"tablist\">
                        <li role=\"presentation\" class=\"active\"><a href=\"#login\" aria-controls=\"login\" role=\"tab\"
                                                                  data-toggle=\"tab\">Login</a>
                        </li>
                        <li role=\"presentation\">
                            <a href=\"";
        // line 18
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_registration_register");
        echo "\">Sign up</a>
                        </li>
                    </ul>

                    <div class=\"tab-content\">
                        <div role=\"tabpanel\" class=\"tab-pane active\" id=\"login\">
                            <form class=\"omb_loginForm\" action=\"";
        // line 24
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_security_check");
        echo "\"
                                  autocomplete=\"off\"
                                  method=\"POST\">
                                <div class=\"form-group\">
                                    <label>
                                        Username
                                    </label>
                                    <input type=\"text\" class=\"\" name=\"_username\" placeholder=\"Username\" value=\"";
        // line 31
        if (((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 31, $this->source); })()) && twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 31, $this->source); })()), "token", array()), "user", array()))) {
            echo " ";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 31, $this->source); })()), "token", array()), "user", array()), "html", null, true);
            echo " ";
        }
        echo "\">
                                </div>
                                <span class=\"help-block\"></span>

                                <div class=\"form-group\">
                                    <label for=\"\">Password</label>
                                    <input type=\"password\" class=\"\" name=\"_password\" placeholder=\"Password\">
                                </div>
                                <span class=\"help-block\"></span>
                                ";
        // line 41
        echo "                                ";
        // line 42
        echo "                                ";
        // line 43
        echo "                                <div class=\"form-group\">
                                    <div class=\"row\">
                                        <div class=\"col-xs-7\" style=\"padding-right:0;\">
                                            <button class=\"btn btn-lg btn-login btn-block\" type=\"submit\">Login</button>
                                        </div>
                                        <div class=\"col-xs-5\">
                                            <div class=\"orconnect\">or connect with</div>
                                            <div class=\"row omb_socialButtons\">
                                                <div class=\"col-xs-6\" style=\"padding-right:7px;\">
                                                    <a href=\"";
        // line 52
        echo twig_escape_filter($this->env, $this->extensions['HWI\Bundle\OAuthBundle\Twig\Extension\OAuthExtension']->getLoginUrl("facebook"), "html", null, true);
        echo "\"
                                                       class=\"btn btn-lg btn-block omb_btn-facebook\">
                                                        <i class=\"fa fa-facebook\"></i>
                                                    </a>
                                                </div>
                                                <div class=\"col-xs-6\" style=\"padding-left:7px;\">
                                                    <a href=\"";
        // line 58
        echo twig_escape_filter($this->env, $this->extensions['HWI\Bundle\OAuthBundle\Twig\Extension\OAuthExtension']->getLoginUrl("google"), "html", null, true);
        echo "\"
                                                       class=\"btn btn-lg btn-block omb_btn-google\">
                                                        <i class=\"fa fa-google\"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class=\"text-center\">
                                <a href=\"";
        // line 69
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_resetting_request");
        echo "\">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 80
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 81
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "

    <script>
        var ecwid_sso_profile = '';

        var objUser = {
            id:  null,
            username: null,
            first_name: null,
            last_name: null,
            email: null
        };

        var config = {
            apiKey: \"AIzaSyBY0fxFNhJqtaKHNvPcd17I77C3-98csdE\",
            authDomain: \"kayakfirste2.firebaseapp.com\",
            databaseURL: \"https://kayakfirste2.firebaseio.com\",
            projectId: \"kayakfirste2\",
            storageBucket: \"kayakfirste2.appspot.com\",
            messagingSenderId: \"319095211483\"
        };
        firebase.initializeApp(config);

        //adatok lekérése
        firebase.database().ref('js_fb_login_details/')
            .once('value')
            .then(function(objData){
                objData.forEach(function(loginData) {
                    console.log(loginData.val().username + ' has logged in at ' + loginData.val().timestamp + ' what is ' + loginData.val().sortdate);
                });
            })
            .catch(function(error){
                console.log(error);
            });

        //adatok lekérve sortolva dátum szerint
        firebase.database().ref('js_fb_login_details/').orderByChild(\"sortdate\").once('value').then(function(foo){
            foo.forEach(function(bar){
                console.log(bar.val().sortdate);
            });
        });

        //adatok lekérése, és ha a username nem zoltanbogar akkor törli a node-ot
        firebase.database().ref('js_fb_login_details/')
            .once('value')
            .then(function(objData){
                objData.forEach(function(loginData) {
                    if(loginData.val().username != \"zoltanbogar\"){
                        let invalidUsername = loginData.val().username;
                        firebase.database().ref('js_fb_login_details/').child(loginData.key).remove();
                        console.log('Invalid username: ' + invalidUsername + ' was deleted!');
                    }
                });
            })
            .catch(function(error){
                console.log(error);
            });

        //adatok lekérése úgy, hogy sortdate szerint sorba vannak rendezve és csak az első 3at adja vissza
        firebase.database().ref('js_fb_login_details/')
            .orderByChild(\"sortdate\")
            .limitToFirst(3)
            .once('value')
            .then(function(foo){
                foo.forEach(function(bar){
                    console.log(bar.val());
                });
            });

        \$('button[type=\"submit\"]').on('click', function(){
            let username = \$('input[name=\"_username\"]').val();
            let password = \$('input[name=\"_password\"]').val();

            \$.ajax({
                type: \"POST\",
                url: 'firebase/login',
                data: ({
                    username: username,
                    password: password
                }),
                dataType: \"json\",
                success: function (data) {
                    \$.extend(objUser, data);
                    console.log(objUser);
                    signInOrSignUp(password);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest, textStatus, errorThrown);
                }
            });


        });

        var signInOrSignUp = password => {
            firebase.auth().signInWithEmailAndPassword(objUser.email, password)
                .then(insertLoginAction())
                .catch(function(error){
                    console.log(error.code);
                    if(error.code === \"auth/user-not-found\"){
                        signUpWithEmailPassword(password);
                    } else {
                        console.log(error);
                    }
                });
        };

        var signUpWithEmailPassword = password => {
            firebase.auth().createUserWithEmailAndPassword(objUser.email, password)
                .then(function(){
                    signInOrSignUp(password);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };

        var insertLoginAction = () => {
            firebase.database().ref('js_fb_login_details/').push({
                username: objUser.username,
                timestamp: moment(new Date()).format(\"Y-MM-DD H:mm:ss\"),
                sortdate: +new Date(),
                id: objUser.id,
                firstname: objUser.first_name,
                lastname: objUser.last_name,
                email: objUser.email
            }, function(error){
                if(error){
                    console.log(error);
                    alert('Data could not be saved!');
                } else {
                    console.log('Data saved successfully!');
                }
            });

            firebase.database().ref('js_web_online_users/'+objUser.id).set({
                username: objUser.username,
                timestamp: moment(new Date()).format(\"Y-MM-DD H:mm:ss\"),
                sortdate: +new Date(),
                id: objUser.id,
                firstname: objUser.first_name,
                lastname: objUser.last_name,
                email: objUser.email
            }, function(error){
                if(error){
                    console.log(error);
                    alert('Data could not be saved!');
                } else {
                    console.log('Data saved successfully!');
                }
            });
        };
    </script>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return ":signin:form_login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  164 => 81,  158 => 80,  141 => 69,  127 => 58,  118 => 52,  107 => 43,  105 => 42,  103 => 41,  87 => 31,  77 => 24,  68 => 18,  58 => 10,  52 => 8,  50 => 7,  45 => 4,  39 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '::layout.html.twig' %}

{% block body %}
    <div class=\"container\">
        <div class=\"form-container\">

            {% if error %}
                <div class=\"error-container\">{{ error.messageKey|trans(error.messageData, 'security') }}</div>
            {% endif %}

            <div class=\"row\">
                <div class=\"col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4\">
                    <ul class=\"nav nav-tabs\" role=\"tablist\">
                        <li role=\"presentation\" class=\"active\"><a href=\"#login\" aria-controls=\"login\" role=\"tab\"
                                                                  data-toggle=\"tab\">Login</a>
                        </li>
                        <li role=\"presentation\">
                            <a href=\"{{ path('fos_user_registration_register') }}\">Sign up</a>
                        </li>
                    </ul>

                    <div class=\"tab-content\">
                        <div role=\"tabpanel\" class=\"tab-pane active\" id=\"login\">
                            <form class=\"omb_loginForm\" action=\"{{ path('fos_user_security_check') }}\"
                                  autocomplete=\"off\"
                                  method=\"POST\">
                                <div class=\"form-group\">
                                    <label>
                                        Username
                                    </label>
                                    <input type=\"text\" class=\"\" name=\"_username\" placeholder=\"Username\" value=\"{% if error and error.token.user %} {{error.token.user}} {% endif %}\">
                                </div>
                                <span class=\"help-block\"></span>

                                <div class=\"form-group\">
                                    <label for=\"\">Password</label>
                                    <input type=\"password\" class=\"\" name=\"_password\" placeholder=\"Password\">
                                </div>
                                <span class=\"help-block\"></span>
                                {#<label class=\"checkbox\">#}
                                {#<input type=\"checkbox\" value=\"remember-me\">Remember Me#}
                                {#</label>#}
                                <div class=\"form-group\">
                                    <div class=\"row\">
                                        <div class=\"col-xs-7\" style=\"padding-right:0;\">
                                            <button class=\"btn btn-lg btn-login btn-block\" type=\"submit\">Login</button>
                                        </div>
                                        <div class=\"col-xs-5\">
                                            <div class=\"orconnect\">or connect with</div>
                                            <div class=\"row omb_socialButtons\">
                                                <div class=\"col-xs-6\" style=\"padding-right:7px;\">
                                                    <a href=\"{{ hwi_oauth_login_url('facebook') }}\"
                                                       class=\"btn btn-lg btn-block omb_btn-facebook\">
                                                        <i class=\"fa fa-facebook\"></i>
                                                    </a>
                                                </div>
                                                <div class=\"col-xs-6\" style=\"padding-left:7px;\">
                                                    <a href=\"{{ hwi_oauth_login_url('google') }}\"
                                                       class=\"btn btn-lg btn-block omb_btn-google\">
                                                        <i class=\"fa fa-google\"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class=\"text-center\">
                                <a href=\"{{ path('fos_user_resetting_request') }}\">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
{% endblock %}

{% block javascripts %}
    {{ parent() }}

    <script>
        var ecwid_sso_profile = '';

        var objUser = {
            id:  null,
            username: null,
            first_name: null,
            last_name: null,
            email: null
        };

        var config = {
            apiKey: \"AIzaSyBY0fxFNhJqtaKHNvPcd17I77C3-98csdE\",
            authDomain: \"kayakfirste2.firebaseapp.com\",
            databaseURL: \"https://kayakfirste2.firebaseio.com\",
            projectId: \"kayakfirste2\",
            storageBucket: \"kayakfirste2.appspot.com\",
            messagingSenderId: \"319095211483\"
        };
        firebase.initializeApp(config);

        //adatok lekérése
        firebase.database().ref('js_fb_login_details/')
            .once('value')
            .then(function(objData){
                objData.forEach(function(loginData) {
                    console.log(loginData.val().username + ' has logged in at ' + loginData.val().timestamp + ' what is ' + loginData.val().sortdate);
                });
            })
            .catch(function(error){
                console.log(error);
            });

        //adatok lekérve sortolva dátum szerint
        firebase.database().ref('js_fb_login_details/').orderByChild(\"sortdate\").once('value').then(function(foo){
            foo.forEach(function(bar){
                console.log(bar.val().sortdate);
            });
        });

        //adatok lekérése, és ha a username nem zoltanbogar akkor törli a node-ot
        firebase.database().ref('js_fb_login_details/')
            .once('value')
            .then(function(objData){
                objData.forEach(function(loginData) {
                    if(loginData.val().username != \"zoltanbogar\"){
                        let invalidUsername = loginData.val().username;
                        firebase.database().ref('js_fb_login_details/').child(loginData.key).remove();
                        console.log('Invalid username: ' + invalidUsername + ' was deleted!');
                    }
                });
            })
            .catch(function(error){
                console.log(error);
            });

        //adatok lekérése úgy, hogy sortdate szerint sorba vannak rendezve és csak az első 3at adja vissza
        firebase.database().ref('js_fb_login_details/')
            .orderByChild(\"sortdate\")
            .limitToFirst(3)
            .once('value')
            .then(function(foo){
                foo.forEach(function(bar){
                    console.log(bar.val());
                });
            });

        \$('button[type=\"submit\"]').on('click', function(){
            let username = \$('input[name=\"_username\"]').val();
            let password = \$('input[name=\"_password\"]').val();

            \$.ajax({
                type: \"POST\",
                url: 'firebase/login',
                data: ({
                    username: username,
                    password: password
                }),
                dataType: \"json\",
                success: function (data) {
                    \$.extend(objUser, data);
                    console.log(objUser);
                    signInOrSignUp(password);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest, textStatus, errorThrown);
                }
            });


        });

        var signInOrSignUp = password => {
            firebase.auth().signInWithEmailAndPassword(objUser.email, password)
                .then(insertLoginAction())
                .catch(function(error){
                    console.log(error.code);
                    if(error.code === \"auth/user-not-found\"){
                        signUpWithEmailPassword(password);
                    } else {
                        console.log(error);
                    }
                });
        };

        var signUpWithEmailPassword = password => {
            firebase.auth().createUserWithEmailAndPassword(objUser.email, password)
                .then(function(){
                    signInOrSignUp(password);
                })
                .catch(function(error) {
                    console.log(error);
                });
        };

        var insertLoginAction = () => {
            firebase.database().ref('js_fb_login_details/').push({
                username: objUser.username,
                timestamp: moment(new Date()).format(\"Y-MM-DD H:mm:ss\"),
                sortdate: +new Date(),
                id: objUser.id,
                firstname: objUser.first_name,
                lastname: objUser.last_name,
                email: objUser.email
            }, function(error){
                if(error){
                    console.log(error);
                    alert('Data could not be saved!');
                } else {
                    console.log('Data saved successfully!');
                }
            });

            firebase.database().ref('js_web_online_users/'+objUser.id).set({
                username: objUser.username,
                timestamp: moment(new Date()).format(\"Y-MM-DD H:mm:ss\"),
                sortdate: +new Date(),
                id: objUser.id,
                firstname: objUser.first_name,
                lastname: objUser.last_name,
                email: objUser.email
            }, function(error){
                if(error){
                    console.log(error);
                    alert('Data could not be saved!');
                } else {
                    console.log('Data saved successfully!');
                }
            });
        };
    </script>
{% endblock %}
", ":signin:form_login.html.twig", "/Users/zoltanbogar/Dev/Projects/kayak/app/Resources/views/signin/form_login.html.twig");
    }
}
