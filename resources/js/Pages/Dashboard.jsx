import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/react';
import UserCard from '../Components/User/UserCard';
import Wishlist from '../Components/User/Wishlist';
import { useEffect, useState } from 'react';
import LoanList from '../Components/Loan/LoanList';

export default function Dashboard({
  auth,
  wishlist,
  loans,
  totalLoans,
  latestBookTitle,
  translations,
}) {
  const { flash } = usePage().props;
  const [showFlash, setShowFlash] = useState(false);

  useEffect(() => {
    if (flash && flash.success) {
      setShowFlash(true);
      const timer = setTimeout(() => {
        setShowFlash(false);
      }, 2000);
      return () => clearTimeout(timer);
    }
  }, [flash]);
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={
        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
          {translations.title}
        </h2>
      }
    >
      <Head title="Dashboard" />

      {showFlash && flash && flash.success && (
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
          <div
            className="bg-green-100 border-green-400 text-green-700 px-4 py-3 rounded relative"
            role="alert"
          >
            <span className="block sm:inline">{flash.success}</span>
          </div>
        </div>
      )}

      <div className="py-12">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900 text-center mb-6">
              <h3 className="text-2xl font-bold">
                {translations.welcome} {auth.user.name}!
              </h3>
            </div>
            <div className="px-6 pb-6">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div className="h-[300px] flex items-center ">
                  <div className="w-full max-w-md">
                    <UserCard
                      user={auth.user}
                      totalLoans={totalLoans}
                      latestBookTitle={latestBookTitle}
                      translations={translations}
                    />
                  </div>
                </div>
                <div className="h-[300px] overflow-hidden">
                  <div className="h-full overflow-y-auto">
                    <Wishlist
                      wishlists={wishlist || []}
                      translations={translations}
                    />
                  </div>
                </div>
              </div>
              <div className="mt-6">
                <LoanList loans={loans} translations={translations} />
              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  );
}
