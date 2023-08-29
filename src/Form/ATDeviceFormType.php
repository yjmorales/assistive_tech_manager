<?php
/**
 * @author Yenier Jimenez <yjmorales86@gmail.com>
 */

namespace App\Form;

use App\Entity\ATDevice;
use App\Entity\ATDeviceType;
use App\Entity\ATPlatform;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Represents the AT Device.
 */
class ATDeviceFormType extends AbstractType
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
                    'help'        => "This value represents the AT Device name.",
                ],
            ])
            ->add('atDeviceType', EntityType::class, [
                'required'     => true,
                'class'        => ATDeviceType::class,
                'choice_label' => 'name',
                'attr'         => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter the device type.',
                    'help'        => "This value represents the AT Device Type.",
                ],
            ])
            ->add('atPlatform', EntityType::class, [
                'required'     => true,
                'class'        => ATPlatform::class,
                'choice_label' => 'name',
                'attr'         => [
                    'class'       => 'form-control',
                    'placeholder' => 'Enter the platform.',
                    'help'        => "This value represents the Platform.",
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ATDevice::class,
        ]);
    }
}
