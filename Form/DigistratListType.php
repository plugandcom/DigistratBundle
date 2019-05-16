<?php

namespace Plugandcom\Bundle\DigistratBundle\Form;

use Exception;
use Plugandcom\Bundle\DigistratBundle\Model\SubList;
use Plugandcom\Bundle\DigistratBundle\Service\DigistratService;
use Symfony\Component\Form\ChoiceList\Factory\ChoiceListFactoryInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DigistratListType extends ChoiceType
{

    /**
     * @var DigistratService
     */
    private $digistratService;

    public function __construct(DigistratService $digistratService, ChoiceListFactoryInterface $choiceListFactory = null)
    {
        parent::__construct($choiceListFactory);
        $this->digistratService = $digistratService;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        try {
            $lists = $this->digistratService->getLists();
        } catch (Exception $e) {
            $lists = [];
        }

        $choices = [];
        foreach ($lists as $list) {
            $choices[$list->getName()] = $list;
        }

        $resolver->setDefaults([
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Veuillez choisir une liste',
            'choices' => $choices,
            'choice_label' => function(SubList $choice) {
                return $choice->getName();
            }
        ]);
    }

}
