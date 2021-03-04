<?php

namespace App\Controller\Admin;

use App\DataTable\Admin\MissionTableType;
use App\Entity\Mission;
use App\Form\Admin\MissionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Umbrella\CoreBundle\Component\Menu\Model\Menu;
use Umbrella\CoreBundle\Controller\BaseController;
use function Symfony\Component\Translation\t;

/**
 * @Route("/mission")
 */
class MissionController extends BaseController
{
    /**
     * @Route("")
     */
    public function indexAction(Request $request)
    {
        $table = $this->createTable(MissionTableType::class);
        $table->handleRequest($request);

        if ($table->isCallback()) {
            return $table->getCallbackResponse();
        }

        return $this->render('@UmbrellaAdmin/DataTable/index.html.twig', [
            'table' => $table
        ]);
    }

    /**
     * @Route(path="/edit/{id}", requirements={"id"="\d+"})
     */
    public function editAction(Request $request, $id = null)
    {
        $this->getMenu()->setCurrent('app_admin_mission_index', Menu::BY_ROUTE);
        $this->getBreadcrumb()->addItem(['label' => $id ? 'action.edit_mission' : 'action.add_mission']);

        if ($id === null) {
            $entity = new Mission();
        } else {
            $entity = $this->findOrNotFound(Mission::class, $id);
        }

        $form = $this->createForm(MissionType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlush($entity);
            $this->toastSuccess(t('message.entity_updated'));
            return $this->redirectToRoute('app_admin_mission_edit', [
                'id' => $entity->id
            ]);
        }

        return $this->render('admin/mission/edit.html.twig', [
            'form' => $form->createView(),
            'entity' => $entity,
        ]);
    }

    /**
     * @Route(path="/delete/{id}", requirements={"id"="\d+"})
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->findOrNotFound(Mission::class, $id);
        $this->removeAndFlush($entity);

        return $this->jsResponseBuilder()
            ->reloadTable()
            ->toastSuccess(t('message.entity_deleted'));
    }

}