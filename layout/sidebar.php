<aside class="sidebar">
    <div class="sidebar-container">
        <ul class="sidebar-menu">
            <?php 
            $menu = buildMenu($_SESSION['user_role_id']);
            
            foreach ($menu as $item): 
                if (empty($item['children'])): ?>
                    <li class="<?php echo $active_menu == basename($item['url'] ?? '', '.php') ? 'active' : ''; ?>">
                        <a href="<?php echo $item['url'] ?? ''; ?>">
                            <?php if (isset($item['icon'])): ?>
                                <i class="<?php echo $item['icon']; ?>"></i>
                            <?php endif; ?>
                            <span><?php echo $item['name'] ?? ''; ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="menu-header"><?php echo $item['name'] ?? ''; ?></li>
                    <?php foreach ($item['children'] as $child): ?>
                        <li class="<?php echo $active_menu == basename($child['url'] ?? '', '.php') ? 'active' : ''; ?>">
                            <a href="<?php echo $child['url'] ?? ''; ?>">
                                <?php if (isset($child['icon'])): ?>
                                    <i class="<?php echo $child['icon']; ?>"></i>
                                <?php endif; ?>
                                <span><?php echo $child['name'] ?? ''; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>
