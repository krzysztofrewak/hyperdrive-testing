<?php

declare(strict_types=1);

use KrzysztofRewak\PhpCsFixer\DoubleQuoteFixer\DoubleQuoteFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

$sets = [
    SetList::CLEAN_CODE,
    SetList::PSR_12,
    SetList::COMMON,
];

$skipped = [
    StandaloneLinePromotedPropertyFixer::class,
    BracesFixer::class,
    SingleQuoteFixer::class,
    ClassAttributesSeparationFixer::class,
    NotOperatorWithSuccessorSpaceFixer::class,
    BinaryOperatorSpacesFixer::class,
    NullableTypeDeclarationForDefaultNullValueFixer::class,
];

$rules = [
    DeclareStrictTypesFixer::class => null,
    CastSpacesFixer::class => ["space" => "none"],
    DoubleQuoteFixer::class => null,
];

return static function (ContainerConfigurator $containerConfigurator) use ($sets, $skipped, $rules): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, ["src"]);
    $parameters->set(Option::SKIP, $skipped);

    $parameters->set(Option::SETS, $sets);

    $services = $containerConfigurator->services();
    foreach ($rules as $rule => $configuration) {
        $service = $services->set($rule);
        if ($configuration) {
            $service->call("configure", [$configuration]);
        }
    }
};
