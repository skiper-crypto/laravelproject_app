<style>
  /* Navbar background with gradient */
  .navbar {
    background: linear-gradient(90deg, #4e54c8, #8f94fb);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }

  /* Brand styling */
  .navbar-brand {
    font-weight: 700;
    font-size: 1.8rem;
    color: #fff !important;
    letter-spacing: 1px;
  }

  /* Navbar links */
  .nav-link {
    color: #d1d1f7 !important;
    font-weight: 500;
    padding: 0.5rem 1rem;
    transition: color 0.3s ease, background-color 0.3s ease;
    border-radius: 6px;
  }

  /* Active link */
  .nav-link.active {
    background-color: rgba(255,255,255,0.25);
    color: #fff !important;
    font-weight: 600;
  }

  /* Hover effect */
  .nav-link:hover {
    background-color: rgba(255,255,255,0.35);
    color: #fff !important;
  }

  /* Toggler icon color */
  .navbar-toggler {
    border-color: #d1d1f7;
  }
  .navbar-toggler-icon {
    filter: invert(1);
  }

  /* Responsive collapse menu background */
  @media (max-width: 991.98px) {
    .navbar-collapse {
      background: linear-gradient(180deg, #4e54c8, #8f94fb);
      padding: 1rem;
      border-radius: 0 0 8px 8px;
    }
  }
</style>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">Ecommerce App</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarText"
      aria-controls="navbarText"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
        </li>
        @auth
          <li class="nav-item">
            <a class="nav-link" href="{{ route('order.history') }}">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('cart.show') }}">Cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">Logout</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
