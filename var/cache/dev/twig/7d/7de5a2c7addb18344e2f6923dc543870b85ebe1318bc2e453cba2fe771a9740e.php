<?php

/* Emails/contactus.html.twig */
class __TwigTemplate_e1549a09c608aae7c0916f3d127e07e955a3ea255b2559e2f03611d35ff2c106 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "Emails/contactus.html.twig"));

        // line 1
        echo "<h3>Új email érkezett a honlapon keresztül</h3>

<p>";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["name"]) || array_key_exists("name", $context) ? $context["name"] : (function () { throw new Twig_Error_Runtime('Variable "name" does not exist.', 3, $this->source); })()), "html", null, true);
        echo " e-mailt küldött a(z) ";
        echo twig_escape_filter($this->env, (isset($context["email"]) || array_key_exists("email", $context) ? $context["email"] : (function () { throw new Twig_Error_Runtime('Variable "email" does not exist.', 3, $this->source); })()), "html", null, true);
        echo " címről.</p>
<br />
<pre>
    ";
        // line 6
        echo twig_escape_filter($this->env, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new Twig_Error_Runtime('Variable "message" does not exist.', 6, $this->source); })()), "html", null, true);
        echo "
</pre>";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    public function getTemplateName()
    {
        return "Emails/contactus.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 6,  30 => 3,  26 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<h3>Új email érkezett a honlapon keresztül</h3>

<p>{{ name }} e-mailt küldött a(z) {{ email }} címről.</p>
<br />
<pre>
    {{ message }}
</pre>", "Emails/contactus.html.twig", "/Users/zoltanbogar/Dev/Projects/kayak/app/Resources/views/Emails/contactus.html.twig");
    }
}
