<?php

namespace App\DataTable\Admin;

use App\Entity\Mission;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Umbrella\CoreBundle\Component\DataTable\Column\PropertyColumnType;
use Umbrella\CoreBundle\Component\DataTable\Column\LinkListColumnType;
use Umbrella\CoreBundle\Component\DataTable\DataTableBuilder;
use Umbrella\CoreBundle\Component\DataTable\DataTableType;
use Umbrella\CoreBundle\Component\DataTable\ToolbarBuilder;
use Umbrella\CoreBundle\Component\UmbrellaLink\UmbrellaLinkList;
use Umbrella\CoreBundle\Component\DataTable\Action\AddActionType;
use Umbrella\CoreBundle\Component\DataTable\Adapter\EntityAdapter;
use Umbrella\CoreBundle\Form\SearchType;

class MissionTableType extends DataTableType
{

    public function buildToolbar(ToolbarBuilder $builder, array $options = array())
    {
        $builder->addFilter('search', SearchType::class);
        $builder->addAction('add', AddActionType::class, array(
            'route' => 'app_admin_mission_edit'
        ));
    }

    public function buildTable(DataTableBuilder $builder, array $options = array())
    {
        $builder->add('id', PropertyColumnType::class);
        $builder->add('title', PropertyColumnType::class);
        $builder->add('actions', LinkListColumnType::class, array(
            'link_builder' => function (UmbrellaLinkList $linkList, Mission $entity) {
                $linkList->addEdit('app_admin_mission_edit', ['id' => $entity->id]);
                $linkList->addXhrDelete('app_admin_mission_delete', ['id' => $entity->id]);
            }
        ));

        // $builder->useEntityAdapter(Mission::class);
        $builder->useAdapter(EntityAdapter::class, [
            'class' => Mission::class,
            'query' => function (QueryBuilder $qb, array $formData) use ($options) {
                if (isset($formData['search'])) {
                    $qb->andWhere('lower(e.search) LIKE :search');
                    $qb->setParameter('search', '%' . strtolower($formData['search']) . '%');
                }
            }
        ]);
    }

}