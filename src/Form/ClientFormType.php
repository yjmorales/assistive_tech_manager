<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Form;

use App\Entity\Client;
use App\Entity\Disability;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Represents the Client Form Type.
 */
class ClientFormType extends AbstractType
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
                    'help'        => "This value represents the client name.",
                ],
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'attr'     => [
                    'class'       => 'form-control',
                    'maxlength'   => 255,
                    'placeholder' => 'Enter the name.',
                    'help'        => "This value represents the client lastname.",
                ],
            ])
            ->add('age', IntegerType::class, [
                'required' => true,
                'attr'     => [
                    'class' => 'form-control',
                    'help'  => "This value represents the client age.",
                ],
            ])
            ->add('disability', EntityType::class, [
                'required'     => true,
                'class'        => Disability::class,
                'multiple'     => true,
                'choice_label' => 'name',
                'attr'         => [
                    'class'       => 'form-control',
                    'placeholder' => 'Select the disability.',
                    'help'        => "This value represents the disability. Please select one or more than one for this client.",
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
