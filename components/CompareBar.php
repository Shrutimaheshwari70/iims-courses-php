<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* ── BASE URL FIX (IMPORTANT) ── */
$b = $asset_base ?? (function () {
  $__script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
  $__parts = explode('/', trim($__script, '/'));
  return '/' . ($__parts[0] ?? '') . '/';
})();

/* ── Remove single ── */
if (isset($_GET['remove']) && !empty($_GET['remove'])) {
  $_SESSION['compare'] = array_values(
    array_filter($_SESSION['compare'] ?? [], fn($s) => $s !== $_GET['remove'])
  );
  header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
  exit;
}

$compareList = $_SESSION['compare'] ?? [];
if (empty($compareList))
  return;

$colleges = array_values(array_filter(array_map(fn($s) => getCollege($s), $compareList)));
?>

<div class="compare-bar" id="compare-bar">
  <div class="compare-bar-inner">

    <div class="compare-bar-label">
      <span class="compare-bar-accent"></span>
      Compare
    </div>

    <div class="compare-bar-slots">
      <?php for ($i = 0; $i < 3; $i++): ?>
        <?php if (isset($colleges[$i])):
          $c = $colleges[$i]; ?>

          <div class="compare-slot filled">
            <div class="compare-slot-logo">

              <?php if (!empty($c['image'])): ?>
                <?php
                $pageBase = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false) ? '../' : '';
                $imgPath = preg_replace('#^(\.\./)*#', '', $c['image']);
                ?>
                <img src="<?= $pageBase . htmlspecialchars($imgPath) ?>" alt="<?= htmlspecialchars($c['name']) ?>"
                  class="compare-slot-img">
              <?php else: ?>
                <span class="compare-slot-initials">IIM</span>
              <?php endif; ?>

            </div>

            <div class="compare-slot-info">
              <span class="compare-slot-name">
                <?= htmlspecialchars($c['name']) ?>
              </span>
              <span class="compare-slot-sub">
                <?= htmlspecialchars($c['location'] ?? 'MBA · PGP') ?>
              </span>
            </div>

            <a href="?remove=<?= urlencode($c['slug']) ?>" class="compare-slot-remove"
              title="Remove <?= htmlspecialchars($c['name']) ?>">
              ✕
            </a>
          </div>

        <?php else: ?>

          <div class="compare-slot empty">
            <div class="compare-slot-add-icon">+</div>
            <a href="<?= $b ?>pages/colleges.php">
              <span class="compare-slot-label">Add College</span>
            </a>
          </div>

        <?php endif; ?>
      <?php endfor; ?>
    </div>

    <div class="compare-bar-divider"></div>

    <div class="compare-bar-actions">

      <a href="<?= $b ?>pages/compare.php" class="compare-btn-primary">
        Compare now
      </a>

      <a href="?clear=1" class="compare-btn-clear">Clear all</a>

    </div>

  </div>
</div>
<style>
  .compare-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 999;
    background: #0F172A;
    border-top: 2px solid #E8500A;
    box-shadow: 0 -8px 28px rgba(0, 0, 0, .28);
    padding: 12px 10px;
    border-radius: 18px 18px 0 0;
    backdrop-filter: blur(10px);
  }

  .compare-bar-inner {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .compare-bar-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: #F8FAFC;
    white-space: nowrap;
    flex-shrink: 0;
  }

  .compare-bar-accent {
    width: 3px;
    height: 18px;
    background: #E8500A;
    border-radius: 2px;
  }

  .compare-bar-slots {
    display: flex;
    gap: 10px;
    flex: 1;
    min-width: 0;
  }

  .compare-slot {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 3px 12px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, .08);
    background: rgba(255, 255, 255, .05);
    min-width: 140px;
    max-width: 220px;
    flex: 1;
    transition: .18s ease;
  }

  .compare-slot.filled:hover {
    border-color: rgba(255, 255, 255, .18);
    transform: translateY(-1px);
  }

  .compare-slot.empty {
    justify-content: center;
    opacity: .75;
    border-style: dashed;
    border-color: rgba(255, 255, 255, .16);
    background: rgba(255, 255, 255, .02);
  }

  .compare-slot-logo {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #1E293B;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
  }

  .compare-slot-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .compare-slot-initials {
    font-size: 9px;
    font-weight: 700;
    color: #fff;
    letter-spacing: .05em;
  }

  .compare-slot-info {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
  }

  .compare-slot-name {
    font-size: 12px;
    font-weight: 600;
    color: #F8FAFC;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .compare-slot-sub {
    font-size: 10px;
    color: #94A3B8;
    margin-top: 2px;
    white-space: nowrap;
  }

  .compare-slot-remove {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 22px;
    height: 22px;
    border-radius: 6px;
    color: #94A3B8;
    text-decoration: none;
    flex-shrink: 0;
    transition: .15s ease;
  }

  .compare-slot-remove:hover {
    background: rgba(232, 80, 10, .14);
    color: #FF7A3D;
  }

  .compare-slot-add-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1.5px dashed #64748B;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .compare-slot-label {
    font-size: 12px;
    color: #94A3B8;
    font-weight: 500;
  }

  .compare-bar-divider {
    width: 1px;
    height: 32px;
    background: rgba(255, 255, 255, .08);
    flex-shrink: 0;
  }

  .compare-bar-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
  }

  .compare-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #E8500A;
    color: #fff;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
    transition: .15s ease;
  }

  .compare-btn-primary:hover {
    background: #C73D06;
    transform: translateY(-1px);
  }

  .compare-btn-clear {
    font-size: 12px;
    font-weight: 500;
    color: #94A3B8;
    text-decoration: none;
    transition: color .12s;
  }

  .compare-btn-clear:hover {
    color: #fff;
  }

  /* ── Tablet (≤900px) ── */
  @media (max-width: 900px) {
    .compare-bar-label {
      display: none;
    }

    .compare-bar-divider {
      display: none;
    }

    .compare-bar-inner {
      gap: 10px;
      flex-wrap: wrap;
    }

    .compare-bar-slots {
      width: 100%;
      order: 1;
    }

    .compare-bar-actions {
      width: 100%;
      order: 2;
      justify-content: space-between;
    }

    .compare-btn-primary {
      flex: 1;
      justify-content: center;
    }

    .compare-slot {
      min-width: 0;
      max-width: none;
      padding: 6px 10px;
    }
  }

  /* ── Mobile (≤540px) ── */
  @media (max-width: 540px) {
    .compare-bar {
      padding: 10px 12px;
    }

    .compare-bar-slots {
      gap: 6px;
    }

    .compare-slot {
      gap: 6px;
      padding: 5px 8px;
    }

    .compare-slot-sub {
      display: none;
    }

    .compare-slot-logo {
      width: 26px;
      height: 26px;
      border-radius: 6px;
    }

    .compare-slot-name {
      font-size: 11px;
    }

    .compare-slot-remove {
      width: 18px;
      height: 18px;
    }

    .compare-slot-add-icon {
      width: 16px;
      height: 16px;
    }

    .compare-slot-label {
      font-size: 11px;
    }

    .compare-btn-primary {
      padding: 9px 14px;
      font-size: 12px;
    }

    .compare-btn-clear {
      font-size: 11px;
    }
  }
</style>