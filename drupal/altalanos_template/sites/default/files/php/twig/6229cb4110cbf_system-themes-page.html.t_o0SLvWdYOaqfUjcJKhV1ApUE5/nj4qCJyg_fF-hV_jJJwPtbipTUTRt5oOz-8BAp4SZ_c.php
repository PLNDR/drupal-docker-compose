<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/altalanos_template/templates/system-themes-page.html.twig */
class __TwigTemplate_8aa044f27dacb611b2e18199163fc68b2cbf8a089e961a6c2f68014264f55331 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 34
        echo "<div";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["attributes"] ?? null), 34, $this->source), "html", null, true);
        echo ">
  ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["theme_groups"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["theme_group"]) {
            // line 36
            echo "    ";
            // line 37
            $context["theme_group_classes"] = [0 => "system-themes-list", 1 => ("system-themes-list-" . $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source,             // line 39
$context["theme_group"], "state", [], "any", false, false, true, 39), 39, $this->source)), 2 => "clearfix"];
            // line 43
            echo "    <div";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme_group"], "attributes", [], "any", false, false, true, 43), "addClass", [0 => ($context["theme_group_classes"] ?? null)], "method", false, false, true, 43), 43, $this->source), "html", null, true);
            echo ">
      ";
            // line 44
            $context["break"] = false;
            // line 45
            echo "      ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["theme_group"], "themes", [], "any", false, false, true, 45));
            foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                if ( !($context["break"] ?? null)) {
                    // line 46
                    echo "        ";
                    if (!twig_in_filter(twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, true, 46), [0 => "Bartik", 1 => "Claro", 2 => "Olivero", 3 => "Seven", 4 => "Stark"])) {
                        // line 47
                        echo "          <h2 class=\"system-themes-list__header\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme_group"], "title", [], "any", false, false, true, 47), 47, $this->source), "html", null, true);
                        echo "</h2>
          ";
                        // line 48
                        $context["break"] = true;
                        // line 49
                        echo "        ";
                    }
                    // line 50
                    echo "      ";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 51
            echo "     
      ";
            // line 52
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["theme_group"], "themes", [], "any", false, false, true, 52));
            foreach ($context['_seq'] as $context["_key"] => $context["theme"]) {
                // line 53
                echo "        ";
                if (!twig_in_filter(twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, true, 53), [0 => "Bartik", 1 => "Claro", 2 => "Olivero", 3 => "Seven", 4 => "Stark"])) {
                    // line 54
                    echo "          ";
                    // line 55
                    $context["theme_classes"] = [0 => ((twig_get_attribute($this->env, $this->source,                     // line 56
$context["theme"], "is_default", [], "any", false, false, true, 56)) ? ("theme-default") : ("")), 1 => ((twig_get_attribute($this->env, $this->source,                     // line 57
$context["theme"], "is_admin", [], "any", false, false, true, 57)) ? ("theme-admin") : ("")), 2 => "theme-selector", 3 => "clearfix"];
                    // line 62
                    echo "          <div";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["theme"], "attributes", [], "any", false, false, true, 62), "addClass", [0 => ($context["theme_classes"] ?? null)], "method", false, false, true, 62), 62, $this->source), "html", null, true);
                    echo ">
            ";
                    // line 63
                    if (twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 63)) {
                        // line 64
                        echo "              ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "screenshot", [], "any", false, false, true, 64), 64, $this->source), "html", null, true);
                        echo "
            ";
                    }
                    // line 66
                    echo "            <div class=\"theme-info\">
              <h3 class=\"theme-info__header\">";
                    // line 68
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "name", [], "any", false, false, true, 68), 68, $this->source), "html", null, true);
                    echo " ";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "version", [], "any", false, false, true, 68), 68, $this->source), "html", null, true);
                    // line 69
                    if (twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 69)) {
                        // line 70
                        echo "                  (";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->safeJoin($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "notes", [], "any", false, false, true, 70), 70, $this->source), ", "));
                        echo ")";
                    }
                    // line 72
                    echo "</h3>
              <div class=\"theme-info__description\">";
                    // line 73
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "description", [], "any", false, false, true, 73), 73, $this->source), "html", null, true);
                    echo "</div>
              ";
                    // line 74
                    if (twig_get_attribute($this->env, $this->source, $context["theme"], "module_dependencies", [], "any", false, false, true, 74)) {
                        // line 75
                        echo "                <div class=\"theme-info__requires\">
                  ";
                        // line 76
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Requires: @module_dependencies", ["@module_dependencies" => $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "module_dependencies", [], "any", false, false, true, 76), 76, $this->source))]));
                        echo "
                </div>
              ";
                    }
                    // line 79
                    echo "              ";
                    // line 80
                    echo "              ";
                    if (twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 80)) {
                        // line 81
                        echo "                <div class=\"incompatible\">";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "incompatible", [], "any", false, false, true, 81), 81, $this->source), "html", null, true);
                        echo "</div>
              ";
                    } else {
                        // line 83
                        echo "                ";
                        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["theme"], "operations", [], "any", false, false, true, 83), 83, $this->source), "html", null, true);
                        echo "
              ";
                    }
                    // line 85
                    echo "            </div>
          </div>
        ";
                }
                // line 88
                echo "      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 89
            echo "    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['theme_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 91
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "themes/altalanos_template/templates/system-themes-page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  182 => 91,  175 => 89,  169 => 88,  164 => 85,  158 => 83,  152 => 81,  149 => 80,  147 => 79,  141 => 76,  138 => 75,  136 => 74,  132 => 73,  129 => 72,  124 => 70,  122 => 69,  118 => 68,  115 => 66,  109 => 64,  107 => 63,  102 => 62,  100 => 57,  99 => 56,  98 => 55,  96 => 54,  93 => 53,  89 => 52,  86 => 51,  79 => 50,  76 => 49,  74 => 48,  69 => 47,  66 => 46,  60 => 45,  58 => 44,  53 => 43,  51 => 39,  50 => 37,  48 => 36,  44 => 35,  39 => 34,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/altalanos_template/templates/system-themes-page.html.twig", "C:\\Users\\rozsa\\Desktop\\kifu_web_accessibility\\Source Code\\altalanos_template_dev\\themes\\altalanos_template\\templates\\system-themes-page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("for" => 35, "set" => 37, "if" => 46);
        static $filters = array("escape" => 34, "safe_join" => 70, "t" => 76, "render" => 76);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['for', 'set', 'if'],
                ['escape', 'safe_join', 't', 'render'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
