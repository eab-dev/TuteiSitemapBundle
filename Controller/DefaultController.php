<?php

namespace Tutei\SitemapBundle\Controller;

use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\LogicalAnd;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion\Visibility;
use eZ\Publish\Core\MVC\Symfony\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    public function indexAction() {
        $response = new Response();
        $response->setPublic();
        $response->setSharedMaxAge( 86400 );
        $response->headers->set( 'X-Location-Id', 2 );
        $response->headers->set('Content-Type', 'application/xml');
        $repository = $this->getRepository();
        $searchService = $repository->getSearchService();
        $locationService = $repository->getLocationService();

        $classes = $this->container->getParameter('tutei_sitemap.classes');
        $url =  $this->container->getParameter('tutei_sitemap.base_url');

        $query = new Query();
        $query->query = new LogicalAnd(
            array(
                        new ContentTypeIdentifier( $classes ),
                        new Visibility( Visibility::VISIBLE )
            )
        );

        $list = $searchService->findContent($query);

        $results = array();
        foreach ($list->searchHits as $content) {
            $locationId = ($content->valueObject->versionInfo->contentInfo->mainLocationId);
            if ( is_int( $locationId )) {
                $results[] = $locationService->loadLocation( $locationId );
            }
        }

        return $this->render('TuteiSitemapBundle:Default:index.xml.twig',
                array('results' => $results, 'url'=>$url),
                $response);
    }

}
