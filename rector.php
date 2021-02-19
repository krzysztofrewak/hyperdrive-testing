<?php

declare(strict_types=1);

use KrzysztofRewak\PhpCsFixer\DoubleQuoteFixer\DoubleQuoteFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Rector\Core\Configuration\Option;
use Rector\Php80\Rector\Class_\StringableForToStringRector;
use Rector\Set\ValueObject\SetList;

use Rector\TypeDeclaration\Rector\ClassMethod\AddArrayReturnDocTypeRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

$sets = [
    SetList::DEAD_CODE,
    SetList::CODE_QUALITY,
    SetList::DEAD_DOC_BLOCK,
    SetList::NAMING,
    SetList::TYPE_DECLARATION,
    SetList::PHP_80,
];

$skipped = [
    SingleQuoteFixer::class,
    ClassAttributesSeparationFixer::class,
    NotOperatorWithSuccessorSpaceFixer::class,
    BinaryOperatorSpacesFixer::class,
    NullableTypeDeclarationForDefaultNullValueFixer::class,
    StringableForToStringRector::class,
    AddArrayReturnDocTypeRector::class,
];

$rules = [
    DeclareStrictTypesFixer::class => null,
    CastSpacesFixer::class => ["space" => "none"],
    DoubleQuoteFixer::class => null,
];

return static function (ContainerConfigurator $containerConfigurator) use ($sets, $skipped, $rules): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::SETS, $sets);
    $parameters->set(Option::SKIP, $skipped);

    $parameters->set(Option::PATHS, ["src"]);

    $services = $containerConfigurator->services();
    foreach ($rules as $rule => $configuration) {
        $service = $services->set($rule);
        if ($configuration) {
            $service->call("configure", [$configuration]);
        }
    }
};
