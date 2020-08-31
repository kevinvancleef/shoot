<?php
declare(strict_types=1);

namespace Shoot\Shoot\Twig\Node;

use Twig\Compiler;
use Twig\Node\ModuleNode;
use Twig\Node\Node;

/**
 * This node is added to the top of the display method of a Twig template and is used by Shoot to wrap the method's
 * contents in a callback.
 *
 * @internal
 */
final class DisplayStartNode extends Node
{
    /** @var FindPresentationModelInterface */
    private $findPresentationModel;

    /** @var ModuleNode */
    private $module;

    /**
     * @param ModuleNode                     $module
     * @param FindPresentationModelInterface $findPresentationModel
     */
    public function __construct(ModuleNode $module, FindPresentationModelInterface $findPresentationModel)
    {
        parent::__construct();

        $this->module = $module;
        $this->findPresentationModel = $findPresentationModel;

        $this->setSourceContext($module->getSourceContext());
    }

    /**
     * @param Compiler $compiler
     *
     * @return void
     */
    public function compile(Compiler $compiler): void
    {
        if ($this->module->hasAttribute('is_embedded')) {
            return;
        }

        $presentationModel = $this->findPresentationModel->for($this->getSourceContext());

        $compiler
            ->write("\$presentationModel = new $presentationModel(\$context);\n")
            ->write("\$originalContext = \$context;\n\n")
            ->write("\$callback = function (array \$context) use (\$blocks, \$originalContext, \$macros) {\n")
            ->indent()
            ->write("\$suppressedException = null;\n\n");
    }
}
