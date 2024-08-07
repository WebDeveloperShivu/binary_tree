<?php
require 'binary_tree.php';

$treeData = $tree->getTree(20); // Get data for levels 1 to 5

function renderTree($nodes, $parentId = null) {
    $branch = array_filter($nodes, function($node) use ($parentId) {
        return $node['parent_id'] == $parentId;
    });

    if (empty($branch)) {
        return '';
    }

    $html = '<ul>';
    foreach ($branch as $node) {
        $html .= '<li>';
        $html .= '<div class="node">' . htmlspecialchars($node['data']) . '</div>';
        $html .= renderTree($nodes, $node['id']);
        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Binary Tree Levels 1 to 20</title>
    <style>
        .tree {
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            display: flex;
            justify-content: center;
        }
        .tree ul:before {
            content: '';
            display: block;
            width: 0;
            border-left: 1px solid #ccc;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 50%;
        }
        .tree li {
            list-style-type: none;
            text-align: center;
            position: relative;
            padding: 20px 5px 0 5px;
        }
        .tree li:before, .tree li:after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }
        .tree li:after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }
        .tree li:only-child:after, .tree li:only-child:before {
            display: none;
        }
        .tree li:only-child {
            padding-top: 0;
        }
        .tree li:first-child:before, .tree li:last-child:after {
            border: 0 none;
        }
        .tree li:last-child:before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
        }
        .tree li:first-child:after {
            border-radius: 5px 0 0 0;
        }
        .tree ul ul:before {
            left: 50%;
            border: 0 none;
        }
        .tree .node {
            border: 1px solid #ccc;
            padding: 10px;
            text-decoration: none;
            color: #666;
            font-family: Arial, Verdana, Tahoma;
            font-size: 12px;
            display: inline-block;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #fff;
            transition: all 0.5s;
        }
        .tree .node:hover {
            background: #c8e4f8;
            color: #000;
            border: 1px solid #94a0b4;
        }
        .tree li a:hover+ul li:before, .tree li a:hover+ul li:after, .tree li a:hover+ul ul:before, .tree li a:hover+ul ul ul:before {
            border-color: #94a0b4;
        }
    </style>
</head>
<body>
    <h1>Binary Tree Levels 1 to 5</h1>
    <div class="tree">
        <?php echo renderTree($treeData); ?>
    </div>
</body>
</html>
