<?php

/* :secret:home.html.twig */
class __TwigTemplate_fd3b900efbeaa092950b0ae2918c64190e00ba8a51aaec47b6477ebfeaf3b81f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("::layout.html.twig", ":secret:home.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'stylesheets' => array($this, 'block_stylesheets'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", ":secret:home.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-3\">
                <div class=\"box sm full-height\">
                    <h2>Date</h2>
                    <div class=\"date-container\" data-training-days-url=\"";
        // line 9
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("webapi_get_training_days");
        echo "\">

                    </div>
                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"row\">
                    <div class=\"col-md-4 session-col\">
                        <div class=\"box semi-height\">
                            <h2>Sessions</h2>
                            <div class=\"box-body\">
                                <table class=\"table table-hover text-center\" id=\"session-table\"
                                       data-trainings-url=\"";
        // line 21
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("webapi_get_training_avgs");
        echo "\">
                                    <thead>
                                        <tr>
                                            <th class=\"text-center\"></th>
                                            <th class=\"text-center\" width=\"33%\">Start</th>
                                            <th class=\"text-center\" width=\"33%\">Duration</th>
                                            <th class=\"text-center\">Distance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-8 results-col\">
                        <div class=\"box avg-table semi-height results\">
                            <h2>Average</h2>

                            <div class=\"row\" id=\"avg-table\">
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-1000\"><h4>Pace<br><span
                                                class=\"uom\">1000m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-500\"><h4>Pace<br><span
                                                class=\"uom\">500m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-200\"><h4>Pace<br><span
                                                class=\"uom\">200m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-speed\"><h4>Speed<br><span class=\"uom\">km/h</span>
                                    </h4><span
                                            class=\"avg-value\">-</span><span class=\"uom\"></span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-stroke\"><h4>Stroke<br><span
                                                class=\"uom\">/min</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pull-force\"><h4>Pull force<br><span
                                                class=\"uom\">N</span></h4><span
                                            class=\"avg-value\">-</span></div>
                            </div>

                            <hr>
                            <h2>Best</h2>

                            <div class=\"row\" id=\"best-table\">
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-1000\"><h4>Pace<br><span
                                                class=\"uom\">1000m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-500\"><h4>Pace<br><span
                                                class=\"uom\">500m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-200\"><h4>Pace<br><span
                                                class=\"uom\">200m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-speed\"><h4>Speed<br><span
                                                class=\"uom\">km/h</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-stroke\"><h4>Stroke<br><span
                                                class=\"uom\">/min</span></h4><span class=\"best-value\">-</span>
                                </div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pull-force\"><h4>Pull force<br><span
                                                class=\"uom\">N</span>
                                    </h4><span
                                            class=\"best-value\">-</span></div>
                            </div>
                        </div>
                    </div>
                    <div class=\"chart-options\" id=\"chart-legend\">
                        <div class=\"col-md-6\">
                            <div class=\"row\">
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_1000\" class=\"pace-option chart-option\"
                                           id=\"t_1000-graph-toggle\" value=\"in process\">
                                    <label for=\"t_1000-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 1000M</span>
                                        <span class=\"value\" id=\"tooltip-t_1000\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_500\" class=\"pace-option chart-option\"
                                           id=\"t_500-graph-toggle\" value=\"in process\">
                                    <label for=\"t_500-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 500M</span>
                                        <span class=\"value\" id=\"tooltip-t_500\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_200\" class=\"pace-option chart-option\"
                                           id=\"t_200-graph-toggle\" value=\"in process\">
                                    <label for=\"t_200-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 200M</span>
                                        <span class=\"value\" id=\"tooltip-t_200\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"speed\" class=\"speed-option chart-option\"
                                           id=\"speed-graph-toggle\" value=\"in process\">
                                    <label for=\"speed-graph-toggle\" class=\"speed_box\">
                                        <span class=\"label\">Speed</span>
                                        <span class=\"value\" id=\"tooltip-speed\"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"row\">
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"strokes\" class=\"strokes-option chart-option\"
                                           id=\"strokes-graph-toggle\" value=\"in process\">
                                    <label for=\"strokes-graph-toggle\" class=\"strokes_box\">
                                        <span class=\"label\">Strokes</span>
                                        <span class=\"value\" id=\"tooltip-strokes\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"pull_force\" class=\"pull-force-option chart-option\"
                                           id=\"pull_force-graph-toggle\" value=\"in process\">
                                    <label for=\"pull_force-graph-toggle\" class=\"pull_force_box\">
                                        <span class=\"label\">Pull force</span>
                                        <span class=\"value\" id=\"tooltip-pull_force\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <label class=\"border_white_4p\">
                                        <span class=\"label\">Time</span>
                                        <span class=\"value\" id=\"tooltip-time\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <label class=\"border_white_4p\">
                                        <span class=\"label\">Distance (m)</span>
                                        <span class=\"value\" id=\"tooltip-currant_distance\"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"instructions\">
        <b>Zoom in</b>: Click on diagram and move cursor right to mark you want to zoom in.
        <b>Zoom out</b>: Click on diagram and move cursor left.
    </div>

    <div id=\"chart\"></div>

    <div id=\"loading-overlay\"><img src=\"";
        // line 168
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("images/loading.gif"), "html", null, true);
        echo "\" alt=\"Loading\"></div>
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 170
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 171
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "

    <link href=\"";
        // line 173
        echo twig_escape_filter($this->env, $this->extensions['Symfony\Bridge\Twig\Extension\AssetExtension']->getAssetUrl("secret/home/Home.css", "views_css"), "html", null, true);
        echo "\" rel=\"stylesheet\">
";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return ":secret:home.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  238 => 173,  232 => 171,  226 => 170,  217 => 168,  67 => 21,  52 => 9,  45 => 4,  39 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends '::layout.html.twig' %}

{% block body %}
    <div class=\"container-fluid\">
        <div class=\"row\">
            <div class=\"col-md-3\">
                <div class=\"box sm full-height\">
                    <h2>Date</h2>
                    <div class=\"date-container\" data-training-days-url=\"{{ path(\"webapi_get_training_days\") }}\">

                    </div>
                </div>
            </div>
            <div class=\"col-md-9\">
                <div class=\"row\">
                    <div class=\"col-md-4 session-col\">
                        <div class=\"box semi-height\">
                            <h2>Sessions</h2>
                            <div class=\"box-body\">
                                <table class=\"table table-hover text-center\" id=\"session-table\"
                                       data-trainings-url=\"{{ path(\"webapi_get_training_avgs\") }}\">
                                    <thead>
                                        <tr>
                                            <th class=\"text-center\"></th>
                                            <th class=\"text-center\" width=\"33%\">Start</th>
                                            <th class=\"text-center\" width=\"33%\">Duration</th>
                                            <th class=\"text-center\">Distance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class=\"col-md-8 results-col\">
                        <div class=\"box avg-table semi-height results\">
                            <h2>Average</h2>

                            <div class=\"row\" id=\"avg-table\">
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-1000\"><h4>Pace<br><span
                                                class=\"uom\">1000m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-500\"><h4>Pace<br><span
                                                class=\"uom\">500m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pace-200\"><h4>Pace<br><span
                                                class=\"uom\">200m</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-speed\"><h4>Speed<br><span class=\"uom\">km/h</span>
                                    </h4><span
                                            class=\"avg-value\">-</span><span class=\"uom\"></span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-stroke\"><h4>Stroke<br><span
                                                class=\"uom\">/min</span></h4><span
                                            class=\"avg-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"avg-pull-force\"><h4>Pull force<br><span
                                                class=\"uom\">N</span></h4><span
                                            class=\"avg-value\">-</span></div>
                            </div>

                            <hr>
                            <h2>Best</h2>

                            <div class=\"row\" id=\"best-table\">
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-1000\"><h4>Pace<br><span
                                                class=\"uom\">1000m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-500\"><h4>Pace<br><span
                                                class=\"uom\">500m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pace-200\"><h4>Pace<br><span
                                                class=\"uom\">200m</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-speed\"><h4>Speed<br><span
                                                class=\"uom\">km/h</span></h4><span
                                            class=\"best-value\">-</span></div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-stroke\"><h4>Stroke<br><span
                                                class=\"uom\">/min</span></h4><span class=\"best-value\">-</span>
                                </div>
                                <div class=\"col-sm-4 col-md-2\" id=\"best-pull-force\"><h4>Pull force<br><span
                                                class=\"uom\">N</span>
                                    </h4><span
                                            class=\"best-value\">-</span></div>
                            </div>
                        </div>
                    </div>
                    <div class=\"chart-options\" id=\"chart-legend\">
                        <div class=\"col-md-6\">
                            <div class=\"row\">
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_1000\" class=\"pace-option chart-option\"
                                           id=\"t_1000-graph-toggle\" value=\"in process\">
                                    <label for=\"t_1000-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 1000M</span>
                                        <span class=\"value\" id=\"tooltip-t_1000\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_500\" class=\"pace-option chart-option\"
                                           id=\"t_500-graph-toggle\" value=\"in process\">
                                    <label for=\"t_500-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 500M</span>
                                        <span class=\"value\" id=\"tooltip-t_500\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"t_200\" class=\"pace-option chart-option\"
                                           id=\"t_200-graph-toggle\" value=\"in process\">
                                    <label for=\"t_200-graph-toggle\" class=\"pace_box\">
                                        <span class=\"label\">Pace 200M</span>
                                        <span class=\"value\" id=\"tooltip-t_200\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"speed\" class=\"speed-option chart-option\"
                                           id=\"speed-graph-toggle\" value=\"in process\">
                                    <label for=\"speed-graph-toggle\" class=\"speed_box\">
                                        <span class=\"label\">Speed</span>
                                        <span class=\"value\" id=\"tooltip-speed\"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class=\"col-md-6\">
                            <div class=\"row\">
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"strokes\" class=\"strokes-option chart-option\"
                                           id=\"strokes-graph-toggle\" value=\"in process\">
                                    <label for=\"strokes-graph-toggle\" class=\"strokes_box\">
                                        <span class=\"label\">Strokes</span>
                                        <span class=\"value\" id=\"tooltip-strokes\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <input type=\"checkbox\" data-name=\"pull_force\" class=\"pull-force-option chart-option\"
                                           id=\"pull_force-graph-toggle\" value=\"in process\">
                                    <label for=\"pull_force-graph-toggle\" class=\"pull_force_box\">
                                        <span class=\"label\">Pull force</span>
                                        <span class=\"value\" id=\"tooltip-pull_force\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <label class=\"border_white_4p\">
                                        <span class=\"label\">Time</span>
                                        <span class=\"value\" id=\"tooltip-time\"></span>
                                    </label>
                                </div>
                                <div class=\"col-sm-3 col-xs-6 graph-button\">
                                    <label class=\"border_white_4p\">
                                        <span class=\"label\">Distance (m)</span>
                                        <span class=\"value\" id=\"tooltip-currant_distance\"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=\"instructions\">
        <b>Zoom in</b>: Click on diagram and move cursor right to mark you want to zoom in.
        <b>Zoom out</b>: Click on diagram and move cursor left.
    </div>

    <div id=\"chart\"></div>

    <div id=\"loading-overlay\"><img src=\"{{ asset('images/loading.gif') }}\" alt=\"Loading\"></div>
{% endblock %}
{% block stylesheets%}
    {{ parent() }}

    <link href=\"{{ asset('secret/home/Home.css', 'views_css') }}\" rel=\"stylesheet\">
{% endblock %}
", ":secret:home.html.twig", "/Users/zoltanbogar/Dev/Projects/kayak/app/Resources/views/secret/home.html.twig");
    }
}
