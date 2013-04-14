<?php
/**
 * Antwoord Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace Controller;

/**
 * Antwoord Controller
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Antwoord extends \Controller
{
    
    /**
     * Antwoord Overzicht
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/index" })
     * @ViewConfig({Layout = "default"})
     * 
     * @return void
     */
    public function index() {
              
        $pagination = $this->View->helper('Pagination');
        /* @var $pagination \View\Helper\Pagination */

        
        $pagination
            ->setSessionStorage('AntwoordIndexFront', array('sort', 'direction', 'zoektekst'))
            ->setPageSize(10)
            ->setSearchConditions(array(
                'zoektekst' => $pagination->getParameter('zoektekst', ''),
                'tag' => $pagination->getParameter('tag', '')
            ))
            ->setBaseParameters(array(
                'zoektekst' => $pagination->getParameter('zoektekst', ''),
                'tag' => $pagination->getParameter('tag', '')                
            ))            
            ->setDefaultBaseUrl(r()->getBase() . '/antwoord/index')
            ->setAllowedSortingFields(array('id', 'aangemaakt', 'titel'))
            ->setDefaultSorting('id', 'DESC')
            ->setContainerModel(new \Model\AntwoordContainer())
            ->paginate();

        
        
        $this->View->setTitle(__('Antwoorden'));
    }

    
     /**
     * Antwoord tonen
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/view"})
     * @ViewConfig({Layout = "default" })
     * 
     * @return void
     */
    public function view($id) {                
        
        $antwoord_container = new \Model\AntwoordContainer();
        if (null === ($antwoord = $antwoord_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Antwoord niet gevonden!', 'exception'));
        }
        
        $antwoord_container->trackWeergave($antwoord->getId());
        
        $session = \KoolDevelop\Session\Session::getInstance();
        $this->View->set('ranked', $session->get('ranked_' . $antwoord->getId(), 0));
        
        $this->View->set('antwoord', $antwoord);
        $this->View->setTitle($antwoord->getTitel());
        
    }
    
    /**
     * Antwoord beoordelen
     * 
     * @param int $id Id
     * @param int $beoordeling Beoordeling (0/1)
     * 
     * @return void
     */
    public function beoordeel($id, $beoordeling) {                
        
        $antwoord_container = new \Model\AntwoordContainer();
        if (null === ($antwoord = $antwoord_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Antwoord niet gevonden!', 'exception'));
        }
        
        $antwoord_container->rankAntwoord($antwoord->getId(), $beoordeling);
        
        $session = \KoolDevelop\Session\Session::getInstance();
        $session->set('ranked_' . $antwoord->getId(), 1);        
        $this->redirect('antwoord/view/' . $antwoord->getId());
        
    }
    
    /**
     * Callback ($model, $data) nadat waarden uit model zijn geladen 
     * 
     * @param \Model  $model Model
     * @param mixed[] $data  Formulier data
     * 
     * @return void
     */
    public function addedit_loaded(\Model &$model, &$data) {
        $data['tags'] = '';
        if ($model->getId() !== null) {
            $tags = array();
            $tag_container = new \Model\TagContainer();
            foreach($tag_container->index(array('antwoord_id' => $model->getId())) as $tag) {
                $tags[] = $tag->getTag();
            }
            $data['tags'] = join('|', $tags);
        }
    }
    
    
    /**
     * Callback ($model, $data) nadat waarden in model zijn geladen.
     * Deze callback kan door middel van het teruggeven van false het verdere
     * opslaan stoppen (b.v. voor custom validatie)
     * 
     * @param \Model  $model Model
     * @param mixed[] $data  Formulier data
     * 
     * @return boolean Verder met opslaan
     */
    public function addedit_saved(\Model &$model, &$data) {
        
        if (isset($data['tags'])) {

            if ($model->getId() === null) {
                $antwoord_container = new \Model\AntwoordContainer();
                $antwoord_container->save($model);
            }

            $tag_container = new \Model\TagContainer();
            $tag_container->delete(array('antwoord_id' => $model->getId()));
            
            foreach(explode('|', $data['tags']) as $tag_tag) {
                $tag = new \Model\Tag();
                $tag->setAntwoordId($model->getId());
                $tag->setTag($tag_tag);
                $tag_container->save($tag);
            }
            
        }
        
        return true;        
    }
    
    /**
     * Overzicht van antwoorden weergeven
     *
     * @ViewConfig({AutoRender = true, View = "antwoord/beheer_index"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_index() {
        
        $pagination = $this->View->helper('Pagination');
        /* @var $pagination \View\Helper\Pagination */

        
        $pagination
            ->setSessionStorage('AntwoordIndex', array('sort', 'direction', 'zoektekst'))
            ->setPageSize(25)
            ->setSearchConditions(array(
                'zoektekst' => $pagination->getParameter('zoektekst', '')
            ))
            ->setBaseParameters(array(
                'zoektekst' => $pagination->getParameter('zoektekst', '')
            ))            
            ->setDefaultBaseUrl(r()->getBase() . '/beheer/antwoord/index')
            ->setAllowedSortingFields(array('id', 'aangemaakt', 'titel'))
            ->setDefaultSorting('id', 'DESC')
            ->setContainerModel(new \Model\AntwoordContainer())
            ->paginate();

        $this->View->setTitle(__('Antwoorden beheren', 'beheer'));
        
    }
    
    
    /**
     * Antwoord toevoegen
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/beheer_add"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_add() {
                
        $antwoord_container = new \Model\AntwoordContainer();
        $antwoord = $antwoord_container->newObject();
        
        $velden = array('titel', 'vraag', 'antwoord');        
        $converter = new \KoolDevelop\Model\SimpleArrayConverter($velden);
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add(array('titel', 'vraag', 'antwoord'), 'Required', '', __('Dit is een verplicht veld', 'beheer'), true)
            ->add('titel', 'RegEx', '.{4,}', __('Geef een titel van minimaal 4 tekens in', 'beheer'));            
        
        if ($this->addedit($antwoord, $velden, $converter, array())) {            
            $antwoord_container->save($antwoord);
            $this->setMelding(self::MELDING_SUCCES, __('Antwoord succesvol opgeslagen', 'beheer'));
            $this->redirect('/beheer/antwoord/view/' . $antwoord->getId());            
        }
        
        $tag_container = new \Model\TagContainer();
        $this->View->set('tags', $tag_container->getDistinctTags());
        
        $this->View->set('antwoord', $antwoord);
        $this->View->setTitle(__('Antwoord toevoegen', 'beheer'));

    }
    
    
    
    /**
     * Antwoord wijzigen
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/beheer_edit"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_edit($id) {
                
        
        $antwoord_container = new \Model\AntwoordContainer();
        if (null === ($antwoord = $antwoord_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Antwoord niet gevonden!', 'exception'));
        }
        
        $velden = array('titel', 'vraag', 'antwoord');        
        $converter = new \KoolDevelop\Model\SimpleArrayConverter($velden);
        
        $validator = $this->View->helper('Validatie');
        /* @var $validator \View\Helper\Validatie */
        
        // Stel validatie regels in
        $validator
            ->add(array('titel', 'vraag', 'antwoord'), 'Required', '', __('Dit is een verplicht veld', 'beheer'), true)
            ->add('titel', 'RegEx', '.{4,}', __('Geef een titel van minimaal 4 tekens in', 'beheer'));            
        
        if ($this->addedit($antwoord, $velden, $converter)) {            
            $antwoord_container->save($antwoord);
            $this->setMelding(self::MELDING_SUCCES, __('Antwoord succesvol opgeslagen', 'beheer'));
            $this->redirect('/beheer/antwoord/view/' . $antwoord->getId());            
        }
        
        $tag_container = new \Model\TagContainer();
        $this->View->set('tags', $tag_container->getDistinctTags());
        
        $this->View->set('antwoord', $antwoord);
        $this->View->setTitle(sprintf(__('Antwoord "%s" wijzigen', 'beheer'), $antwoord->getTitel()));

    }
    
     /**
     * Antwoord tonen
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/beheer_view"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_view($id) {                
        
        $antwoord_container = new \Model\AntwoordContainer();
        if (null === ($antwoord = $antwoord_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Antwoord niet gevonden!', 'exception'));
        }
        
        $this->View->set('antwoord', $antwoord);
        $this->View->setTitle(sprintf(__('Details voor "%s"', 'beheer'), $antwoord->getTitel()));
        
    }
    
    /**
     * Antwoord tonen
     * 
     * @ViewConfig({AutoRender = true, View = "antwoord/beheer_view"})
     * @ViewConfig({Layout = "beheer" })
     * 
     * @return void
     */
    public function beheer_delete($id) {                
        
        $antwoord_container = new \Model\AntwoordContainer();
        if (null === ($antwoord = $antwoord_container->first(array('id' => $id)))) {
            throw new \KoolDevelop\Exception\NotFoundException(__f('Antwoord niet gevonden!', 'exception'));
        }
        
        $antwoord_container->delete(array('id' => $antwoord->getId()));
        $this->setMelding(self::MELDING_SUCCES, __('Antwoord succesvol gewist', 'beheer'));
        $this->redirect('/beheer/antwoord/index');
        
    }
    
    
}