<?php

/* ::layout.html.twig */
class __TwigTemplate_173f01b761020f846e23126ec0dc87b7d3a2c57c92d3f78fa5611e7bb57f44ca extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
            'ecwid' => array($this, 'block_ecwid'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "::layout.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\"/>
    <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin-ext\" rel=\"stylesheet\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

    <link href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/bootstrap.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/datepicker/bootstrap-datepicker.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/font-awesome.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/selectize.bootstrap3.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/EJSChart.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("css/style.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
    <style type=\"text/css\">
        @font-face {
            font-family: 'Gotham-Italic';
            src:    url(";
        // line 18
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("fonts/Gotham-BookItalic.otf"), "html", null, true);
        echo ") format('opentype');
        }
    </style>
    ";
        // line 21
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 22
        echo "    <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\"/>
</head>
<body>
<header>
    <nav class=\"navbar navbar-kayak\">
        <div class=\"container-fluid\">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class=\"navbar-header\">
                <div class=\"navbar-logo-div\">
                    <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\"
                        data-target=\"#kayak-navbar-collapse\" aria-expanded=\"false\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </button>
                </div>
                <div class=\"navbar-toggle-div\">
                    <a class=\"navbar-brand_bkp\" href=\"http://www.kayakfirst.com\">
                            <div class=\"LOGO\">Kayakfirst</div>
                    </a>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class=\"collapse navbar-collapse\" id=\"kayak-navbar-collapse\">
                <ul class=\"nav navbar-nav navbar-right\">
                    ";
        // line 49
        if ($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) {
            // line 50
            echo "                        <li class=\"nav-li-left\">
                            <span class=\"ec-cart-widget\"></span>
                        </li>
                        <li class=\"nav-li-left\">
                            <a href=\"";
            // line 54
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("shop");
            echo "\">
                                <span>Webshop</span>
                            </a>
                        </li>
                    ";
        }
        // line 59
        echo "                    <li class=\"nav-li-left\">
                        <a href=\"";
        // line 60
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("homepage");
        echo "\">
                            <span class=\"glyphicon glyphicon-home\"></span>
                        </a>
                    </li>
                    ";
        // line 64
        if ($this->extensions['Symfony\Bridge\Twig\Extension\SecurityExtension']->isGranted("ROLE_USER")) {
            // line 65
            echo "                        <li class=\"nav-li-left\">
                            <a href=\"";
            // line 66
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("logout_user");
            echo "\">
                                <span class=\"glyphicon glyphicon-log-out\"></span>
                            </a>
                        </li>
                        <li class=\"nav-li-right\">
                            <a href=\"";
            // line 71
            echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("fos_user_profile_show");
            echo "\">
                                <span>Signed in as <b>";
            // line 72
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["app"]) || array_key_exists("app", $context) ? $context["app"] : (function () { throw new Twig_Error_Runtime('Variable "app" does not exist.', 72, $this->source); })()), "user", array()), "username", array()), "html", null, true);
            echo "</b></span>
                            </a>
                        </li>
                    ";
        }
        // line 76
        echo "                </ul>
                
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
";
        // line 82
        $this->displayBlock('body', $context, $blocks);
        // line 83
        $this->displayBlock('javascripts', $context, $blocks);
        // line 151
        echo "</body>
</html>




";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Kayakfirst!";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 21
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 82
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 83
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        // line 84
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/jquery-3.1.1.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 85
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"https://www.gstatic.com/firebasejs/5.0.4/firebase.js\"></script>
    <script src=\"";
        // line 87
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/datepicker/bootstrap-datepicker.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 88
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/selectize.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 89
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/moment.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"https://unpkg.com/axios/dist/axios.min.js\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js\"></script>
    <script src=\"";
        // line 92
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/ejschart/EJSChart.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 93
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/public-v2.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 94
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("js/moment.js"), "html", null, true);
        echo "\"></script>

    ";
        // line 96
        $this->displayBlock('ecwid', $context, $blocks);
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function block_ecwid($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "ecwid"));

        // line 97
        echo "        <script>
            if(typeof ecwid_sso_profile == \"undefined\"){
                var ecwid_sso_profile = '';
            }

            var ajax_ecwid_login = () => {
                \$.ajax({
                    type: \"POST\",
                    url: 'ecwid_login',
                    data: ({
                    }),
                    dataType: \"json\",
                    success: function(data){
                        ecwid_sso_profile = data.ecwid_sso_profile;
                        loadScript(\"https://app.ecwid.com/script.js?14262098&data_platform=code&data_date=2018-07-09\", runProd);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
            };

            var loadScript = (url, callback) => {
                var script = document.createElement(\"script\");
                script.type = \"text/javascript\";
                script.charset=\"utf-8\";

                if(script.readyState){
                    script.onreadystatechange = function(){
                        if(script.readyState == \"loaded\" || script.readyState == \"complete\"){
                            script.onreadystatechange = null;
                            callback();
                        }
                    };
                } else {
                    script.onload = function(){
                        callback();
                    };
                }

                script.src = url;
                document.getElementsByTagName(\"head\")[0].appendChild(script);
            };

            var runProd = () => {
                Ecwid.init();
                if(\$('#my-store-14262098').length > 0)
                    xProductBrowser(\"categoriesPerRow=3\",\"views=grid(20,3) list(60) table(60)\",\"categoryView=grid\",\"searchView=list\",\"id=my-store-14262098\");
            };

            ajax_ecwid_login();
        </script>
    ";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "::layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  274 => 97,  262 => 96,  257 => 94,  253 => 93,  249 => 92,  243 => 89,  239 => 88,  235 => 87,  230 => 85,  225 => 84,  219 => 83,  208 => 82,  197 => 21,  185 => 5,  172 => 151,  170 => 83,  168 => 82,  160 => 76,  153 => 72,  149 => 71,  141 => 66,  138 => 65,  136 => 64,  129 => 60,  126 => 59,  118 => 54,  112 => 50,  110 => 49,  79 => 22,  77 => 21,  71 => 18,  64 => 14,  60 => 13,  56 => 12,  52 => 11,  48 => 10,  44 => 9,  37 => 5,  31 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\"/>
    <title>{% block title %}Kayakfirst!{% endblock %}</title>
    <link href=\"https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin-ext\" rel=\"stylesheet\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">

    <link href=\"{{ asset('css/bootstrap.min.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/datepicker/bootstrap-datepicker.min.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/font-awesome.min.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/selectize.bootstrap3.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/EJSChart.css') }}\" rel=\"stylesheet\">
    <link href=\"{{ asset('css/style.css') }}\" rel=\"stylesheet\">
    <style type=\"text/css\">
        @font-face {
            font-family: 'Gotham-Italic';
            src:    url({{asset('fonts/Gotham-BookItalic.otf')}}) format('opentype');
        }
    </style>
    {% block stylesheets %}{% endblock %}
    <link rel=\"icon\" type=\"image/x-icon\" href=\"{{ asset('favicon.ico') }}\"/>
</head>
<body>
<header>
    <nav class=\"navbar navbar-kayak\">
        <div class=\"container-fluid\">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class=\"navbar-header\">
                <div class=\"navbar-logo-div\">
                    <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\"
                        data-target=\"#kayak-navbar-collapse\" aria-expanded=\"false\">
                        <span class=\"sr-only\">Toggle navigation</span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                        <span class=\"icon-bar\"></span>
                    </button>
                </div>
                <div class=\"navbar-toggle-div\">
                    <a class=\"navbar-brand_bkp\" href=\"http://www.kayakfirst.com\">
                            <div class=\"LOGO\">Kayakfirst</div>
                    </a>
                </div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class=\"collapse navbar-collapse\" id=\"kayak-navbar-collapse\">
                <ul class=\"nav navbar-nav navbar-right\">
                    {% if is_granted('ROLE_USER') %}
                        <li class=\"nav-li-left\">
                            <span class=\"ec-cart-widget\"></span>
                        </li>
                        <li class=\"nav-li-left\">
                            <a href=\"{{ path('shop') }}\">
                                <span>Webshop</span>
                            </a>
                        </li>
                    {% endif %}
                    <li class=\"nav-li-left\">
                        <a href=\"{{ path('homepage') }}\">
                            <span class=\"glyphicon glyphicon-home\"></span>
                        </a>
                    </li>
                    {% if is_granted('ROLE_USER') %}
                        <li class=\"nav-li-left\">
                            <a href=\"{{ path('logout_user') }}\">
                                <span class=\"glyphicon glyphicon-log-out\"></span>
                            </a>
                        </li>
                        <li class=\"nav-li-right\">
                            <a href=\"{{ path('fos_user_profile_show') }}\">
                                <span>Signed in as <b>{{ app.user.username }}</b></span>
                            </a>
                        </li>
                    {% endif %}
                </ul>
                
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>
{% block body %}{% endblock %}
{% block javascripts %}
    <script src=\"{{ asset('js/jquery-3.1.1.js') }}\"></script>
    <script src=\"{{ asset('js/bootstrap.min.js') }}\"></script>
    <script src=\"https://www.gstatic.com/firebasejs/5.0.4/firebase.js\"></script>
    <script src=\"{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}\"></script>
    <script src=\"{{ asset('js/selectize.min.js') }}\"></script>
    <script src=\"{{ asset('js/moment.min.js') }}\"></script>
    <script src=\"https://unpkg.com/axios/dist/axios.min.js\"></script>
    <script src=\"https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js\"></script>
    <script src=\"{{ asset('js/ejschart/EJSChart.js') }}\"></script>
    <script src=\"{{ asset('js/public-v2.js') }}\"></script>
    <script src=\"{{ asset('js/moment.js') }}\"></script>

    {% block ecwid %}
        <script>
            if(typeof ecwid_sso_profile == \"undefined\"){
                var ecwid_sso_profile = '';
            }

            var ajax_ecwid_login = () => {
                \$.ajax({
                    type: \"POST\",
                    url: 'ecwid_login',
                    data: ({
                    }),
                    dataType: \"json\",
                    success: function(data){
                        ecwid_sso_profile = data.ecwid_sso_profile;
                        loadScript(\"https://app.ecwid.com/script.js?14262098&data_platform=code&data_date=2018-07-09\", runProd);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest, textStatus, errorThrown);
                    }
                });
            };

            var loadScript = (url, callback) => {
                var script = document.createElement(\"script\");
                script.type = \"text/javascript\";
                script.charset=\"utf-8\";

                if(script.readyState){
                    script.onreadystatechange = function(){
                        if(script.readyState == \"loaded\" || script.readyState == \"complete\"){
                            script.onreadystatechange = null;
                            callback();
                        }
                    };
                } else {
                    script.onload = function(){
                        callback();
                    };
                }

                script.src = url;
                document.getElementsByTagName(\"head\")[0].appendChild(script);
            };

            var runProd = () => {
                Ecwid.init();
                if(\$('#my-store-14262098').length > 0)
                    xProductBrowser(\"categoriesPerRow=3\",\"views=grid(20,3) list(60) table(60)\",\"categoryView=grid\",\"searchView=list\",\"id=my-store-14262098\");
            };

            ajax_ecwid_login();
        </script>
    {% endblock %}
{% endblock %}
</body>
</html>




", "::layout.html.twig", "/Users/zoltanbogar/Dev/Projects/kayak/app/Resources/views/layout.html.twig");
    }
}
