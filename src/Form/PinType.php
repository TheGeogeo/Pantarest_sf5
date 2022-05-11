<?php

namespace App\Form;

use App\Entity\Pin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $pin = $options['data'];
        $inEditMode = $pin && $pin->getId();

        $contraints = [
            new Image([
                "maxSize" => "8M",
                "maxSizeMessage" => "The max size is '{{ limit }}' but your file is to weight '{{ size }}'."
            ])
        ];

        if (!$inEditMode) array_push($contraints, new NotNull(["message" => "Please upload a picture."]));


        $builder
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image (JPG or PNG file)',
                'required' => false,
                'allow_delete' => false,
                'delete_label' => 'Delete',
                'download_label' => 'Download',
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
                'constraints' => $contraints
            ])
            ->add('title')
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
