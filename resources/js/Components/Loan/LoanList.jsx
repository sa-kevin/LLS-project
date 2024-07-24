import { router } from '@inertiajs/react';
import { parseISO, format } from 'date-fns';
import { useState } from 'react';
import { route } from 'ziggy-js';

export default function LoanList({ loans: initialLoans, translations }) {
  const [loans, setLoans] = useState(initialLoans);

  const formatDate = (dateString) => {
    if (!dateString) return '';
    const date = parseISO(dateString);
    return format(date, 'MMMM d yyyy');
  };

  const handleReturnBook = (loanId) => {
    router.post(
      route('loans.return', loanId),
      {},
      {
        preserveState: true,
        preserveScroll: true,
        onSuccess: (page) => {
          // Check if the updated loan is returned from the server
          const updatedLoan = page.props.loan;
          if (updatedLoan) {
            setLoans((prevLoans) =>
              prevLoans
                .map((loan) =>
                  loan.id === updatedLoan.id ? updatedLoan : loan
                )
                .sort((a, b) => {
                  if (a.returned_at === null && b.returned_at !== null)
                    return -1;
                  if (a.returned_at !== null && b.returned_at === null)
                    return 1;
                  return new Date(a.due_date) - new Date(b.due_date);
                })
            );
          } else {
            // If the server doesn't return the updated loan, update the loan status locally
            setLoans((prevLoans) =>
              prevLoans
                .map((loan) =>
                  loan.id === loanId
                    ? { ...loan, returned_at: new Date().toISOString() }
                    : loan
                )
                .sort((a, b) => {
                  if (a.returned_at === null && b.returned_at !== null)
                    return -1;
                  if (a.returned_at !== null && b.returned_at === null)
                    return 1;
                  return new Date(a.due_date) - new Date(b.due_date);
                })
            );
          }
        },
      }
    );
  };
  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h3 className="text-2xl font-bold mb-6">{translations.loaned}</h3>
      <div className="bg-white shadow-sm rounded-lg overflow-hidden">
        {loans.length === 0 ? (
          <p className="p-6 text-gray-700">You have no loaned books.</p>
        ) : (
          loans.map((loan) => (
            <div
              key={loan.id}
              className="border-b border-gray-200 last:border-b-0"
            >
              <div className="p-6 grid grid-cols-3 gap-4 items-center">
                <div className="space-y-1 col-span-1">
                  <h4 className="font-bold text-lg">{loan.book.title}</h4>
                  <p className="text-gray-600 text-sm">{loan.book.author}</p>
                </div>
                <div className="text-center col-span-1">
                  {!loan.returned_at && (
                    <p className="text-gray-600 font-semibold text-sm">
                      {translations.due} {formatDate(loan.due_date)}
                    </p>
                  )}
                </div>
                <div className="text-right col-span-1">
                  {!loan.returned_at ? (
                    <button
                      onClick={() => handleReturnBook(loan.id)}
                      className="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded transition duration-150 ease-in-out"
                    >
                      {translations.return}
                    </button>
                  ) : (
                    <p className="text-green-600 font-bold text-sm">
                      {translations.returned} {formatDate(loan.returned_at)}
                    </p>
                  )}
                </div>
              </div>
            </div>
          ))
        )}
      </div>
    </div>
  );
}
