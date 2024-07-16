import { Link, Head } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Welcome({ auth }) {
  return (
    <>
      <Head title="Tech Book - Library Loan System" />
      <div className="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div className="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
          <div className="relative w-full max-w-2xl px-6 lg:max-w-7xl">
            <header className="grid grid-cols-2 items-center gap-2 py-5 lg:grid-cols-3">
              <div className="flex items-center gap-2  ">
                <img
                  className="h-32 w-auto"
                  src="/images/logo.svg"
                  alt="My Logo"
                />
                <h1 className="text-xl lg:text-4xl font-title font-medium">
                  Tech Book
                </h1>
              </div>
              <nav className="-mx-3 flex flex-1 justify-end lg:col-start-3">
                {auth.user ? (
                  <Link
                    href={route('dashboard')}
                    className="font-main rounded-md px-3 py-2 text-black/80 ring-1 ring-transparent transition hover:text-black/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                  >
                    Dashboard
                  </Link>
                ) : (
                  <>
                    <Link
                      href={route('login')}
                      className="font-main font-medium rounded-md px-3 py-2 text-black/80 ring-1 ring-transparent transition hover:text-black/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                      Log in
                    </Link>
                    <Link
                      href={route('register')}
                      className="font-main font-medium rounded-md px-3 py-2 text-black/80 ring-1 ring-transparent transition hover:text-black/50 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                      Register
                    </Link>
                  </>
                )}
              </nav>
            </header>

            <main className="mt-6">
              <div className="grid gap-6 lg:grid-cols-1 lg:gap-8">
                <h2 className=" font-klee text-5xl md:text-6xl font-bold text-black/50 mb-12 text-center">
                  <span className="block text-cyan-600 dark:text-cyan-400">
                    Which book
                  </span>
                  <span className="block text-cyan-600 dark:text-cyan-400 ">
                    do you want to read?
                  </span>
                </h2>
                <div className="relative w-screen left-1/2 right-1/2 -mx-[50vw]">
                  <img
                    className="w-full"
                    src="/images/waves3c.svg"
                    alt="Wave background"
                  />
                </div>
              </div>
            </main>

            <footer className="py-16 text-center text-sm text-black dark:text-white/70">
              <p className="text-sm">
                &copy; {new Date().getFullYear()} Tech Book. All rights
                reserved.
              </p>{' '}
            </footer>
          </div>
        </div>
      </div>
    </>
  );
}
