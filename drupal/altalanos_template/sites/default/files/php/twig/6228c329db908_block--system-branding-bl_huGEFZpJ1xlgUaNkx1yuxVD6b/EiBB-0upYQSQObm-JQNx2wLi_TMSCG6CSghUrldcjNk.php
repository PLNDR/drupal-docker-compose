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

/* themes/altalanos_template/templates/block--system-branding-block.html.twig */
class __TwigTemplate_846cb8713a8e4bf849e9da9e48b93aeaa4886de8a8d2e334e3bbf49c4662b0c7 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "block.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 16
        $context["attributes"] = twig_get_attribute($this->env, $this->source, ($context["attributes"] ?? null), "addClass", [0 => "site-branding"], "method", false, false, true, 16);
        // line 1
        $this->parent = $this->loadTemplate("block.html.twig", "themes/altalanos_template/templates/block--system-branding-block.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 17
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 18
        echo "  ";
        if ((($context["site_logo"] ?? null) || ($context["site_name"] ?? null))) {
            // line 19
            echo "    <a class=\"link_change\" href=\"";
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("<front>"));
            echo "\" rel=\"home\" tabindex=\"-1\" aria-hidden=\"true\">
      ";
            // line 20
            if (($context["site_logo"] ?? null)) {
                // line 21
                echo "        <div class=\"site-branding__logo\">
          <img src=\"";
                // line 22
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_logo"] ?? null), 22, $this->source), "html", null, true);
                echo "\" />
        </div>
      ";
            }
            // line 25
            echo "      ";
            if (($context["site_name"] ?? null)) {
                // line 26
                echo "        <div class=\"site-branding__text\">
          <div class=\"site-branding__name\">
            <h1 class=\"site_name_change\">";
                // line 28
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_name"] ?? null), 28, $this->source), "html", null, true);
                echo "</h1>
          </div>
          ";
                // line 30
                if (($context["site_slogan"] ?? null)) {
                    // line 31
                    echo "            <div class=\"site-branding__slogan\">";
                    echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_slogan"] ?? null), 31, $this->source), "html", null, true);
                    echo "</div>
          ";
                }
                // line 33
                echo "        </div>
      ";
            } elseif (            // line 34
($context["site_slogan"] ?? null)) {
                // line 35
                echo "        <div class=\"site-branding__text\">
          <div class=\"site-branding__slogan\">";
                // line 36
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["site_slogan"] ?? null), 36, $this->source), "html", null, true);
                echo "</div>
        </div>
      ";
            }
            // line 39
            echo "    </a>
  ";
        }
    }

    public function getTemplateName()
    {
        return "themes/altalanos_template/templates/block--system-branding-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  108 => 39,  102 => 36,  99 => 35,  97 => 34,  94 => 33,  88 => 31,  86 => 30,  81 => 28,  77 => 26,  74 => 25,  68 => 22,  65 => 21,  63 => 20,  58 => 19,  55 => 18,  51 => 17,  46 => 1,  44 => 16,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/altalanos_template/templates/block--system-branding-block.html.twig", "C:\\Users\\rozsa\\Desktop\\kifu_web_accessibility\\Source Code\\altalanos_template_dev\\themes\\altalanos_template\\templates\\block--system-branding-block.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 16, "if" => 18);
        static $filters = array("escape" => 22);
        static $functions = array("path" => 19);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['escape'],
                ['path']
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
