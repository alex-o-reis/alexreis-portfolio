<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/ProfileSetting.php';
require_once __DIR__ . '/../models/Experience.php';
require_once __DIR__ . '/../models/Skill.php';
require_once __DIR__ . '/../models/EducationItem.php';
require_once __DIR__ . '/../models/Project.php';

class Portfolio extends Controller
{
    public function get()
    {
        $allProjects = Project::listPublished();

        $featured = [];
        $caseStudies = [];
        $mainProjects = [];
        $otherTools = [];

        foreach ($allProjects as $p) {
            if (!empty($p['is_featured'])) {
                $featured[] = $p;
            }
            if (!empty($p['is_case_study'])) {
                $caseStudies[] = $p;
            }
            if ($p['category'] === 'othertool') {
                $otherTools[] = $p;
            } else {
                $mainProjects[] = $p;
            }
        }

        usort($caseStudies, function ($a, $b) {
            return ($a['case_order'] ?? 0) <=> ($b['case_order'] ?? 0);
        });

        return $this->json([
            'profile' => ProfileSetting::getMain(),
            'experiences' => Experience::listVisible(),
            'skills' => Skill::listVisible(),
            'education' => EducationItem::listVisible('degree'),
            'courses' => EducationItem::listVisible('course'),
            'featured_projects' => $featured,
            'case_studies' => $caseStudies,
            'projects' => $mainProjects,
            'other_tools' => $otherTools,
        ]);
    }
}
