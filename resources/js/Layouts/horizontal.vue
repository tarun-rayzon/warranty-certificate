<script>
import { Link } from '@inertiajs/vue3'
import NavBar from '@/Components/nav-bar.vue'
import RightBar from '@/Components/right-bar.vue'
import Footer from '@/Components/footer.vue'

export default {
  data() {
    return {
      isMenuOpen: false,
      activeDropdown: null,
    }
  },
  mounted() {
    this.initActiveMenu()
  },
  methods: {
    initActiveMenu() {
      var currentPath = location.href
      if (currentPath) {
        // navbar-nav
        var a = document.getElementById('navbar-nav').querySelector('[href="' + currentPath + '"]')
        if (a) {
          a.classList.add('active')
          var parentCollapseDiv = a.closest('.collapse.menu-dropdown')
          if (parentCollapseDiv) {
            parentCollapseDiv.classList.add('show')
            parentCollapseDiv.parentElement.children[0].classList.add('active')
            parentCollapseDiv.parentElement.children[0].setAttribute('aria-expanded', 'true')
            if (parentCollapseDiv.parentElement.closest('.collapse.menu-dropdown')) {
              parentCollapseDiv.parentElement.closest('.collapse').classList.add('show')
              if (parentCollapseDiv.parentElement.closest('.collapse').previousElementSibling) parentCollapseDiv.parentElement.closest('.collapse').previousElementSibling.classList.add('active')

              if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest('.collapse.menu-dropdown')) {
                parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest('.collapse').classList.add('show')
                if (parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest('.collapse').previousElementSibling) {
                  parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.closest('.collapse').previousElementSibling.classList.add('active')
                  if (document.documentElement.getAttribute('data-layout') == 'horizontal' && parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest('.collapse')) {
                    parentCollapseDiv.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.closest('.collapse').previousElementSibling.classList.add('active')
                  }
                }
              }
            }
          }
        }
      }
    },
    userHasRole(role) {
      return this.$page.props.user.roles.includes(role)
    },
    hasAnyPermission(requiredPermissions) {
      return requiredPermissions.some((permission) => this.$page.props.user.permissions.includes(permission))
    },
  },
  components: {
    NavBar,
    RightBar,
    Footer,
    Link,
  },
}
</script>

<template>
  <div>
    <div id="layout-wrapper">
      <NavBar />
      <!-- ========== App Menu ========== -->
      <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <!-- Dark Logo-->
          <Link href="/" class="logo logo-dark">
            <span class="logo-sm">
              <img src="@assets/images/logo-sm.png" alt="" height="22" />
            </span>
            <span class="logo-lg">
              <img src="@assets/images/logo-dark.png" alt="" height="30" />
            </span>
          </Link>
          <!-- Light Logo-->
          <Link href="/" class="logo logo-light">
            <span class="logo-sm">
              <img src="@assets/images/logo-sm.png" alt="" height="22" />
            </span>
            <span class="logo-lg">
              <img src="@assets/images/logo-light.png" alt="" height="30" />
            </span>
          </Link>
          <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
          </button>
        </div>
        <div id="scrollbar">
          <BContainer fluid>
            <ul class="navbar-nav" id="navbar-nav">
              <li class="nav-item">
                <Link :href="route('dashboard')" class="nav-link menu-link">
                  <i class="bx bxs-dashboard"></i>
                  <span>Dashboard</span>
                </Link>
              </li>

              <li></li>

              <li class="nav-item">
                <Link :href="route('warranty-requests.index')" class="nav-link menu-link">
                  <i class="bx bx-package"></i>
                  <span>Warranty Requests</span>
                </Link>
              </li>

              <li class="nav-item">
                <Link :href="route('ftr-files.index')" class="nav-link menu-link">
                  <i class="bx bx-file"></i>
                  <span>FTR Files</span>
                </Link>
              </li>
            </ul>
          </BContainer>
          <!-- Sidebar -->
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>
      </div>
      <!-- ============================================================== -->
      <!-- Start Page Content here -->
      <!-- ============================================================== -->

      <div class="main-content">
        <div class="page-content">
          <!-- Start Content-->
          <BContainer fluid>
            <slot />
          </BContainer>
        </div>
        <Footer />
      </div>
      <RightBar />
    </div>
  </div>
</template>
