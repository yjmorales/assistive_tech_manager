<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Form;

use App\Entity\ATDeviceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Represents the AT Device Form Type.
 */
class ATDeviceTypeFormType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Enter the name.',
                    'help'        => "This value represents the AT Device Type name.",
                ],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'attr'     => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter the description.',
                    'help'        => "This value represents the AT Device Type description.",
                ]
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ATDeviceType::class,
        ]);
    }
}
